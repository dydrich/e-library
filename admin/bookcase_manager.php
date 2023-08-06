<?php

/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 25/04/19
 * Time: 18.35
 */


require_once "../lib/start.php";
require_once "../lib/start.php";
require_once "../lib/Room.php";
require_once "../lib/Venue.php";
require_once "../lib/Bookcase.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$rid = $bid = $progressive = $shelves = $bookcase = null;
$bid = $_POST['bid'];
$rid = $_POST['room'];
$room = new \elibrary\Room($rid, null, null, null, new MySQLDataLoader($db));
$room->loadFields();
if ($_POST['action'] == ACTION_INSERT || $_POST['action'] == ACTION_UPDATE) {
	$name = $db->real_escape_string($_POST['bookcase']);
	$code = $_POST['code'];
	$shelves = $_POST['shelves'];
	$bk = new \elibrary\Bookcase($bid, $name, $code, $room, $shelves, new MySQLDataLoader($db));
}
else {
	$bk = new \elibrary\Bookcase($bid, null, null, $room, 0, new MySQLDataLoader($db));
}


header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch ($_POST['action']) {
	case ACTION_INSERT:
		try {
			$begin = $db->executeUpdate("BEGIN");
			//$db->executeUpdate("INSERT INTO rb_bookcases (bid, description, room, shelves) VALUES ($bid, '$bookcase', $rid, $shelves)");
			$bk->insert();
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
			//$db->executeUpdate("DELETE FROM rb_bookcases WHERE bid = {$bid}");
			$bk->delete();
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

