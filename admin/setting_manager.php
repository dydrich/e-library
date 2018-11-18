<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 11.23
 */

require_once "../lib/start.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$name = $val = null;
if($_POST['action'] == ACTION_INSERT){
	$name = $db->real_escape_string(trim($_POST['name']));
	$val = $db->real_escape_string($_POST['val']);
}
$sid = $_POST['sid'];

switch($_POST['action']){
	case ACTION_INSERT:
		header("Content-type: application/json");
		$response = array("status" => "ok", "message" => "Operazione completata");
		try{
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("INSERT INTO rb_settings (var, value, readonly) VALUES ('{$name}', '{$val}', 0)");
			$commit = $db->executeUpdate("COMMIT");
		} catch (\edocs\MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Variabile inserita";
		break;
	case ACTION_DELETE:
		header("Content-type: application/json");
		$response = array("status" => "ok", "message" => "Operazione completata");
		try{
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("DELETE FROM rb_settings WHERE id = $sid");
			$commit = $db->executeUpdate("COMMIT");
		} catch (\edocs\MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Variabile eliminata";
		break;
	case ACTION_UPDATE:
		header("Content-type: text/plain");
		$val = $db->real_escape_string($_POST['val']);
		try{
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("UPDATE rb_settings SET value = '$val' WHERE id = $sid");
			require_once "../lib/load_env.php";
			$commit = $db->executeUpdate("COMMIT");
			print $val;
			exit;
		} catch (\edocs\MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Variabile aggiornata";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;
