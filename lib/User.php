<?php

require_once "AccountManager.php";

class User {
	protected $uid;
	protected $firstName;
	protected $lastName;
	protected $username;
	protected $roles;
	protected $currentRole;
	protected $pwd;
	protected $accesses;
	protected $datasource;
	protected $active;

    /**
     * token for authentication from mobile devices
     * @var $token string
     */
    protected $token;

    public static $ADMIN = 1;
    public static $LIBRARIAN = 2;
    public static $STUDENT = 3;

	public static $NO_EMAIL = 0;
	public static $ACTIVATION_EMAIL = 1;
	public static $DATA_EMAIL = 2;

	public function __construct($u, $fn, $ln, $un, $pwd, $rl, $dl){
		$this->uid = $u;
		$this->firstName = $fn;
		$this->lastName = $ln;
		$this->username = $un;
		$this->roles = $rl;

		$this->currentRole = null;
		if($rl != null) {
			if (count($this->roles) == 1) {
				$this->currentRole = $this->roles[0];
			}
		}
		
		if ($dl instanceof \MySQLDataLoader) {
			$this->datasource = $dl;
		}
		else {
			$this->datasource = new \MySQLDataLoader($dl);
		}
		if ($pwd == null) {
			$pass = AccountManager::generatePassword();
			$this->pwd = $pass;
		}
		else {
			$this->pwd = $pwd;
		}
		$this->active = true;
	}
	
	public function setFirstName($fn){
		$this->firstName = $fn;
	}

	public function getFirstName(){
		return $this->firstName;
	}

	public function setLastName($ln){
		$this->lastName = $ln;
	}

	public function getLastName(){
		return $this->lastName;
	}

	/**
	 * @return mixed
	 */
	public function isActive() {
		return $this->active;
	}

	/**
	 * @param mixed $active
	 */
	public function setActive($active) {
		$this->active = $active;
		if ($active == false) {
			$this->delete(false);
		}
		else {
			$this->restore();
		}
	}

	/**
	 * @param mixed $accesses
	 */
	public function setAccesses($accesses) {
		$this->accesses = $accesses;
	}

	/**
	 * @return mixed
	 */
	public function getAccesses() {
		return $this->accesses;
	}

	/**
	 * @return null
	 */
	public function getCurrentRole() {
		return $this->currentRole;
	}

	/**
	 * @param null $currentRole
	 */
	public function setCurrentRole($currentRole) {
		$this->currentRole = $currentRole;
	}
	
	/**
	 * 
	 * @param number $order: the order of printing
	 * @param number $full: unused (@see ParentBean::getFullName)
	 * @return string
	 */
	public function getFullName($order = 1, $full = 0){
		($order == 1) ? ($ret = $this->firstName." ".$this->lastName) : ($ret = $this->lastName." ".$this->firstName);
		return $ret;
	}

	/**
	 * print name's initials
	 * @param number $order: the order of printing
	 * @param number $dot: print a dot after every initial
	 * @return string
	 */
	public function getInitials($order = 1, $dot = 0) {
		$fn_init = $ln_init = "";
		$fname = explode(" ", $this->firstName);
		foreach ($fname as $item) {
			$fn_init .= substr($item, 0, 1);
			if ($dot) {
				$fn_init .= ".";
			}
		}
		$lname = explode(" ", $this->lastName);
		foreach ($lname as $item) {
			$ln_init .= substr($item, 0, 1);
			if ($dot) {
				$ln_init .= ".";
			}
		}
		if ($dot) {
			($order == 1) ? ($ret = $fn_init." ".$ln_init) : ($ret = $ln_init." ".$fn_init);
		}
		else {
			($order == 1) ? ($ret = $fn_init.$ln_init) : ($ret = $ln_init.$fn_init);
		}
		return $ret;
	}

	public function getRoles(){
		return $this->roles;
	}

	public function setRoles($roles = null){
		if ($roles == null) {
			$this->roles = $this->datasource->executeQuery("SELECT rid FROM rb_user_roles WHERE uid = ".$this->uid);
		}
		else {
			$this->roles = $roles;
		}
	}

	protected function updateRoles() {
		$this->datasource->executeUpdate('DELETE FROM rb_user_roles WHERE uid = '.$this->uid);
		foreach ($this->roles as $role) {
			$this->datasource->executeUpdate('INSERT INTO rb_user_roles (uid, rid) VALUES ('.$this->uid.', '.$role.')');
		}
	}

	public function getUid(){
		return $this->uid;
	}

	public function getUsername(){
		return $this->username;
	}

	public function setPwd(array $p){
		$this->pwd = $p;
	}
	
	public function getPwd(){
		return $this->pwd;
	}

	/**
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * return an array of data in json string format
     * @return array
     */
    public function toJSON() {
        $json_array = [];
        $json_array['uid'] = $this->uid;
        $json_array['fname'] = $this->firstName;
        $json_array['lname'] = $this->lastName;
        $json_array['username'] = $this->username;
        $json_array['token'] = $this->token;
        return $json_array;
    }

    public static function getHumanReadableRole($r) {
    	switch ($r) {
			case 1:
				return "Amministratore";
			case 2:
				return "Bibliotecario";
			case 3:
				return "Studente";
			default:
				return "Studente";
		}
	}

	public static function generatePassword() {

	}

	public function insert ($sendEmail) {
    	$active = 1;
    	$sql = "INSERT INTO rb_users (username, password, firstname, lastname, accesses_count, last_access, previous_access, active, registration_date)  
				VALUES ('{$this->username}', '{$this->pwd['e']}', '{$this->firstName}', '{$this->lastName}', 0, NULL, NULL, $active, NOW())";
    	$this->uid = $this->datasource->executeUpdate($sql);
    	if ($sendEmail === User::$ACTIVATION_EMAIL) {
			$this->sendActivationEmail();
		}
		else if($sendEmail === User::$DATA_EMAIL) {
			$this->sendEmailAccessData();
		}
		$this->updateRoles();
    	return ['login' => $this->username, 'password' => $this->pwd['c']];
	}

	public function update () {
    	if ($this->username == null) {
			$sql = "UPDATE rb_users SET firstname = '{$this->firstName}', lastname = '{$this->lastName}' WHERE uid = ".$this->uid;
		}
		else {
			$sql = "UPDATE rb_users SET username = '{$this->username}', firstname = '{$this->firstName}', lastname = '{$this->lastName}' WHERE uid = ".$this->uid;
		}
		$this->datasource->executeUpdate($sql);
		$this->updateRoles();
	}

	public function delete ($deleteFromDB) {
    	/* TODO: check for books before delete */
    	if ($deleteFromDB) {
    		$sql = "DELETE FROM rb_users WHERE uid = ".$this->uid;
		}
		else {
    		$sql = "UPDATE rb_users SET active = 0 WHERE uid = ".$this->uid;
		}
		$this->datasource->executeUpdate($sql);
	}

	public function restore () {
		$sql = "UPDATE rb_users SET active = 1 WHERE uid = ".$this->uid;

		$this->datasource->executeUpdate($sql);
	}

	protected function sendEmailAccessData() {
    	$pwd = $this->pwd;
		$to = $this->username;
		$from = "edocs@dydrich.net";
		$subject = "Piattaforma e-Docs+";
		$headers = "From: {$from}\r\n"."Reply-To: {$from}\r\n" .'X-Mailer: PHP/' . phpversion();
		$message = "Gentile utente,\nil suo account per l'utilizzo della piattaforma e-Docs+ è stato attivato.\n ";
		$message .= "Di seguito troverà i dati di accesso:\n\n";
		$message .= "username: {$this->username}\npassword: ".$pwd['c']."\n";
		$message .= "Per un corretto funzionamento del software, si raccomanda di NON utilizzare il browser Internet Explorer, ma una versione aggiornata di Firefox, Google Chrome, Opera o Safari.\n";
		//$message .= "Le ricordiamo che, in caso di smarrimento della password, pu&ograve; richiederne una nuova usando il link 'Password dimenticata?' presente nella pagine iniziale del Registro.\n";
		$message .= "Per qualunque problema, non esiti a contattarci.";
		mail($to, $subject, $message, $headers);
	}

	public function sendActivationEmail(){
		/*
	    * generate a random id
		*/
		$uniqid = md5(uniqid(rand(), true));
		$tm = new \DateTime();
		$now = $tm->format("Y-m-d H:i:s");
		try {
			$due = $tm->add(new \DateInterval('P1D'));
		} catch (\Exception $e) {

		}

		$dt = $due->format("Y-m-d H:i:s");
		//$this->datasource->executeUpdate("UPDATE rb_users SET activation_code = '{$uniqid}', code_expire_time = '$dt' WHERE uid = ".$this->uid);

		/*
		 * send email
		 */
		$to = $this->getUsername();
		$subject = "Attivazione nuovo account";
		$from = "edocs@dydrich.net";
		$headers = "From: {$from}\r\n"."Reply-To: {$from}\r\n" .'X-Mailer: PHP/' . phpversion();
		$message = "Gentile utente,\nabbiamo ricevuto la tua richiesta di accesso alla piattaforma.\n ";
		$message .= "Per completare la procedura, clicca sul link seguente entro 24 ore:\n\n";
		$message .= ROOT_SITE."/activate.php?token=".$uniqid."&chk=".$this->uid."\n";
		$message .= "Per qualunque problema, non esitare a contattarci.\n\n";
		$message .= "Si prega di non rispondere a questa mail, in quanto inviata da un programma automatico.\n\n";
		mail($to, $subject, $message, $headers);
	}

	/**
	 * @param MySQLDataLoader $datasource
	 */
	public function setDatasource($datasource) {
		if ($datasource instanceof \MySQLDataLoader) {
			$this->datasource = $datasource;
		}
		else {
			$this->datasource = new \MySQLDataLoader($datasource);
		}
	}

	public function checkRole($admitted) {
		if (in_array($admitted, $this->roles) && $admitted == $this->currentRole) {
			return true;
		}
		return false;
	}
}