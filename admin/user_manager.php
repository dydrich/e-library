<?php

ini_set('display_errors', 1);

require_once "../lib/start.php";
require_once "../lib/User.php";
require_once "../lib/AccountManager.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

if($_POST['action'] != ACTION_DELETE && $_POST['action'] != ACTION_RESTORE){
	$uname = null;
	if (isset($_POST['username'])) {
		$uname = $db->real_escape_string(trim($_POST['username']));
	}
	$nome = $db->real_escape_string(trim($_POST['firstname']));
	$cognome = $db->real_escape_string(trim($_POST['lastname']));
	$role = $_POST['role'];
}
$uid = $_POST['uid'];
$send_email = true;
if ($role == User::$STUDENT) {
	$send_email = false;
}
$roles = [$role];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case ACTION_INSERT:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$user = new User(0, $nome, $cognome, $uname, null, $roles, new MySQLDataLoader($db));
			$response['user'] = $user->insert($send_email);
			$response['data_field'] = 'user';
			$commit = $db->executeUpdate("COMMIT");
        } catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			$st = stripos($response['query'], "for key 'username'");
			if ($st !== true) {
				$response['message'] = "E-mail presente in archivio";
			}
			echo json_encode($response);
			exit;
		}
		$msg = "Utente inserito";
		break;
	case ACTION_DELETE:
       	try{
			$begin = $db->executeUpdate("BEGIN");
			$user = new User($_POST['uid'], "", "", "", null, null, new MySQLDataLoader($db));
			$user->delete(false);
			$begin = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
       	}
        $msg = "Utente ora inattivo";
		break;
	case ACTION_DESTROY:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$user = new User($_POST['uid'], "", "", "", null, null, new MySQLDataLoader($db));
			$user->delete(true);
			$begin = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Utente eliminato in modo definitivo";
		break;
	case ACTION_UPDATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$user = new User($_POST['uid'], $nome, $cognome, $uname, null, $roles, new MySQLDataLoader($db));
			$user->update();
			$begin = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Utente aggiornato";
		break;
	case ACTION_RESTORE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$user = new User($_POST['uid'], null, null, '', null, null, new MySQLDataLoader($db));
			$user->restore();
			$begin = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Utente ripristinato";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;
