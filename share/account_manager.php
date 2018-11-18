<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 11/03/18
 * Time: 9.22
 */

require_once "../lib/start.php";
require_once "../lib/AccountManager.php";
require_once "../lib/RBUtilities.php";

check_session();

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "");

switch ($_REQUEST['action']) {
	case "get_pwd":
		$pwd = \edocs\AccountManager::generatePassword(8, 4);
		$response['pwd'] = $pwd['c'];
		$response['epwd'] = $pwd['e'];
		$res = json_encode($response);
		echo $res;
		exit;
		break;
	case "update_account":
		$uname = $db->real_escape_string($_POST['nick']);
		$pwd = $db->real_escape_string($_POST['pwd']);

		$rb = RBUtilities::getInstance($db);

		try{
			$user = $rb->loadUserFromUid($_REQUEST['id']);
			$account_manager = new \edocs\AccountManager($user, new MySQLDataLoader($db));
			$account_manager->updateAccount($uname, $pwd);
		} catch (\edocs\MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Si è verificato un errore. Riprova tra qualche minuto";
			$response['dbg_message'] = $ex->getQuery()."----".$ex->getMessage();
			$res = json_encode($response);
			echo $res;
			exit;
		}
		$res = json_encode($response);
		echo $res;
		exit;
		break;
	case "change_personal_password":
		$pwd = $db->real_escape_string($_POST['new_pwd']);
		try{
			$user = $_SESSION['__user__'];
			$account_manager = new \edocs\AccountManager($user, new MySQLDataLoader($db));
			$account_manager->changePassword($pwd);
		} catch (\edocs\MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Si è verificato un errore. Riprova tra qualche minuto";
			$response['dbg_message'] = $ex->getQuery()."----".$ex->getMessage();
			$res = json_encode($response);
			echo $res;
			exit;
		}
		$response['message'] = "Password modificata";
		$res = json_encode($response);
		echo $res;
		exit;
		break;
	case "change_username":
		$username = $db->real_escape_string($_POST['new_username']);

		$rb = RBUtilities::getInstance($db);

		try{
			$user = $rb->loadUserFromUid($_REQUEST['uid']);
			$account_manager = new \edocs\AccountManager($user, new MySQLDataLoader($db));
			if ($account_manager->checkUsername($username)) {
				$account_manager->changeUsername($username);
			}
			else {
				$response['status'] = "ko";
				$response['message'] = "Username presente in archivio";
				$res = json_encode($response);
				echo $res;
				exit;
			}
		} catch (\edocs\MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Si è verificato un errore. Riprova tra qualche minuto";
			$response['dbg_message'] = $ex->getQuery()."----".$ex->getMessage();
			$res = json_encode($response);
			echo $res;
			exit;
		}
		$response['message'] = "Username modificata";
		$res = json_encode($response);
		echo $res;
		exit;
		break;
}
