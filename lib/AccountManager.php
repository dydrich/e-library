<?php

namespace edocs;

class AccountManager{

	private $user_;
	private $datasource_;

	public function __construct(\edocs\User $u, \MySQLDataLoader $dl){
		$this->user_ = $u;
		$this->datasource_ = $dl;
	}

	public function recoveryPasswordViaEmail(){
		/*
	    * generate a random id
		*/
		$uniqid = md5(uniqid(rand(), true));
		$tm = new \DateTime();
		$now = $tm->format("Y-m-d H:i:s");
		$due = $tm->add(new \DateInterval('P1D'));
		$area = null;

		$smt = $this->datasource_->prepare("INSERT INTO rb_password_recovery (user, token, request_date, token_due_date) VALUES (?, ?, ?, ?)");
		$id = $this->user_->getUid();
		$dt = $due->format("Y-m-d H:i:s");
		$smt->bind_param("isss", $id, $uniqid, $now, $dt);
		$smt->execute();

		/*
		 * send email
		 */
		$to = $this->user_->getUsername();
		$subject = "Richiesta nuova password";
		$from = "edocs@dydrich.net";
		$headers = "From: {$from}\r\n"."Reply-To: {$from}\r\n" .'X-Mailer: PHP/' . phpversion();
		$message = "Gentile utente,\nabbiamo ricevuto la sua richiesta di una nuova password di accesso alla piattaforma.\n ";
		$message .= "Per modificare la password, clicchi sul link seguente entro 24 ore:\n\n";
		$message .= ROOT_SITE."/change_password.php?token=".$uniqid."\n";
		$message .= "Per qualunque problema, non esiti a contattarci.\n\n";
		$message .= "Si prega di non rispondere a questa mail, in quanto inviata da un programma automatico.\n\n";
		mail($to, $subject, $message, $headers);
	}

	public function changePassword($newPwd) {
		$smt = $this->datasource_->prepare("UPDATE rb_users SET password = ? WHERE uid = ?");
		$uid = $this->user_->getUid();
		$smt->bind_param("si", $newPwd, $uid);
		$smt->execute();
	}

	public function changeUsername($newUsername) {
		$smt = $this->datasource_->prepare("UPDATE rb_users SET username = ? WHERE uid = ?");
		$id = $this->user_->getUid();
		$smt->bind_param("si", $newUsername, $id);
		$smt->execute();
	}

	public function updateAccount($uname, $pwd) {
		$smt = $this->datasource_->prepare("UPDATE rb_users SET username = ?, password = ? WHERE uid = ?");
		$smt->bind_param("ssi", $uname, $pwd, $this->user_->getUid());
		$smt->execute();
	}

	public static function generatePassword($length=9, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bcdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BCDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}

		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		$pwd = array();
		$pwd['c'] = $password;
		$pwd['e'] = md5($password);
		return $pwd;
	}

	public function checkUsername($uname) {
		$names = $this->datasource_->executeCount("SELECT username FROM rb_users WHERE username = '".$uname."' AND uid <> ".$this->user_->getUid());
		if ($names != null) {
			return false;
		}
		return true;
	}

	public function createToken() {
	    $token = hash("md5", $this->user_->getFullName().$this->user_->getUsername().$this->user_->getUniqID());
        $this->user_->setToken($token);

        $smt = $this->datasource_->prepare("UPDATE rb_users SET token = ? WHERE uid = ?");
        $uid = $this->user_->getUid();
        $smt->bind_param("si", $token, $uid);
        $smt->execute();
        return $token;
    }

    public function checkToken() {

    }
}
