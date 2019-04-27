<?php

/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 25/04/19
 * Time: 18.35
 */


require_once "../lib/start.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$rid = $bid = $progressive = $shelves = $bookcase = null;
if ($_POST['action'] == ACTION_INSERT || $_POST['action'] == ACTION_UPDATE) {
	$bookcase = $db->real_escape_string($_POST['bookcase']);
	$progressive = $_POST['progressive'];
	$rid = $_POST['room'];
	$shelves = $_POST['shelves'];
}
$bid = $_POST['bid'];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch ($_POST['action']) {
	case ACTION_INSERT:
		try {
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("INSERT INTO rb_bookcases (bid, description, room, shelves) VALUES ($bid, '$bookcase', $rid, $shelves)");
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex) {
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Armadio inserito";
		break;
	case ACTION_DELETE:
		try {
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("DELETE FROM rb_bookcases WHERE bid = {$bid}");
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex) {
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Armadio eliminato";
		break;
	case ACTION_UPDATE:
		try {
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("UPDATE rb_bookcases SET room = $rid, description = '{$bookcase}', shelves = $shelves WHERE bid = {$bid}");
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex) {
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Armadio aggiornato";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;

