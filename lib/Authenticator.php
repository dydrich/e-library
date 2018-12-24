<?php

require_once 'User.php';
require_once 'RBUtilities.php';
require_once "CustomException.php";

class Authenticator {
	
	private $datasource;
	private $response;

    public function __construct(MySQLDataLoader $dl){
		$this->datasource = $dl;
		$this->response = array();
	}
	
	/**
	 * @return array
	 */
	public function getResponse() {
		return $this->response;
	}
	
	public function login($username, $password){
		$sel_user = "SELECT uid FROM rb_users WHERE username = '{$username}' AND password = '".trim($password)."'";
		$res_user = $this->datasource->executeCount($sel_user);
		if ($res_user == null){
			throw new CustomException("Username o password errata", CustomException::$LOGIN_ERROR_CODE);
		}

		$rb = RBUtilities::getInstance($this->datasource->getSource());
		$user = $rb->loadUserFromUid($res_user);

		if (!$user->isActive()) {
			throw new CustomException("Utente non attivo", CustomException::$USER_NOT_ACTIVE_CODE);
		}

		$update = "UPDATE rb_users SET accesses_count = (rb_users.accesses_count + 1), previous_access = last_access, last_access = NOW() WHERE uid = ".$res_user;
		$upd = $this->datasource->executeUpdate($update);

		$this->response['name'] = $user->getFullName();
		$this->response['role'] = $user->getCurrentRole();
		return $user;
	}

	public function loginWithToken($token, $area) {
	    /*
		$sel_user = "SELECT uid FROM rb_users WHERE token = '{$token}'";
        $uid = $this->datasource->executeCount($sel_user);
        if ($uid == null || $uid == false) {
            return false;
        }
        $rb = RBUtilities::getInstance($this->datasource->getSource());
        $user = $rb->loadUserFromUid($uid);

        $smt = $this->datasource->prepare("UPDATE rb_users SET accesses_count = (rb_users.accesses_count + 1), previous_access = last_access, last_access = NOW() WHERE uid = ?");

        $smt->bind_param("i", $uid);
        $smt->execute();

        return $user;
	    */
    }
}
