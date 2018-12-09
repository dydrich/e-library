<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 24/10/17
 * Time: 7.19
 */
require_once "../lib/start.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$description = null;
if($_POST['action'] != ACTION_DELETE){
	$description = $db->real_escape_string($_POST['year']);
}
$_id = $_POST['_id'];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case ACTION_INSERT:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("INSERT INTO rb_years (description) VALUES ('{$description}')");
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Anno inserito";
		break;
	case ACTION_DELETE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("DELETE FROM rb_years WHERE `_id` = {$_id}");
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Anno eliminato";
		break;
	case ACTION_UPDATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("UPDATE rb_years SET description = '{$description}' WHERE `_id` = {$_id}");
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Anno modificato";
		break;
	case 'SET_AS_DEFAULT':
		try{
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("UPDATE rb_years SET current_year = 0");
			$db->executeUpdate("UPDATE rb_years SET current_year = 1 WHERE `_id` = {$_id}");
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Anno impostato";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;
