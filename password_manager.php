<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 21/10/17
 * Time: 10.12
 */

require_once './lib/start.php';
require_once './lib/RBUtilities.php';
require_once './lib/AccountManager.php';

header("Content-type: application/json");

$response = array("status" => "ok", "message" => "Password modificata correttamente");

if ($_POST['action'] == 'sendmail'){
	if (!check_mail($_POST['email'])){
		$response['status'] = "olduser";
		$response['message'] = "Non hai inserito una email valida";
		echo json_encode($response);
		exit;
	}
	/*
	 * get the user id
	 */
	try{
		$uid = $db->executeCount("SELECT uid FROM rb_users WHERE username = '".$_POST['email']."'");
	} catch (\edocs\MySQLException $ex){
		$response['status'] = "kosql";
		$response['message'] = $ex->getMessage()." === ".$ex->getQuery();
		echo json_encode($response);
		exit;
	}
	if ($uid == null){
		$response['status'] = "nomail";
		$response['message'] = "L'email inserita non è presente in archivio: ricontrolla o rivolgiti all'amministratore";
		echo json_encode($response);
		exit;
	}
	else {
		try{
			$rb = RBUtilities::getInstance($db);
			$user = $rb->loadUserFromUid($uid);
			$am = new \edocs\AccountManager($user, new MySQLDataLoader($db));
			$am->recoveryPasswordViaEmail();
			$response['message'] = "La tua richiesta è stata inviata. ";
		} catch (\edocs\MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = $ex->getMessage()." === ".$ex->getQuery();
			echo json_encode($response);
			exit;
		}
	}
}
else if ($_POST['action'] == "change"){
	$uid = $_POST['uid'];
	$new_pwd = $_POST['new_pwd'];
	try{
		$rb = RBUtilities::getInstance($db);
		$user = $rb->loadUserFromUid($uid);
		$am = new \edocs\AccountManager($user, new MySQLDataLoader($db));
		$am->changePassword($new_pwd);
	} catch (\edocs\MySQLException $ex){
		$response['status'] = "kosql";
		$response['message'] = $ex->getMessage()." === ".$ex->getQuery();
		echo json_encode($response);
		exit;
	}
}

echo json_encode($response);
exit;
