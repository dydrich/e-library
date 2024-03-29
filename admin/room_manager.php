<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/12/18
 * Time: 18.11
 */


require_once "../lib/start.php";
require_once "../lib/Room.php";
require_once "../lib/Venue.php";
require_once "../lib/Archive.php";

ini_set('display_errors', 1);

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$name = $vid = $code = null;
$rid = $_POST['rid'];
$vid = $_POST['venue'];

if($_POST['action'] == ACTION_INSERT || $_POST['action'] == ACTION_UPDATE ){
	$name =  $db->real_escape_string($_POST['room']);
	$code = $db->real_escape_string($_POST['code']);
	$room = new \elibrary\Room($rid, $name, $code, $vid, new MySQLDataLoader($db));
}
else {
	$room = new \elibrary\Room($rid, null, null, $vid, new MySQLDataLoader($db));
}


header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case ACTION_INSERT:
		try{
			$begin = $db->executeUpdate("BEGIN");
			//$db->executeUpdate("INSERT INTO rb_rooms (vid, name) VALUES ($vid, '{$name}')");
			$room->insert();
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
		$msg = "Locale inserito";
		break;
	case ACTION_DELETE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			//$db->executeUpdate("DELETE FROM rb_rooms WHERE rid = {$rid}");
			$room->delete();
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
		$msg = "Locale eliminato";
		break;
	case ACTION_UPDATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			//$db->executeUpdate("UPDATE rb_rooms SET vid= $vid, name = '{$name}', code = {$code} WHERE rid = {$rid}");
			$room->update();
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Locale aggiornato";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;
