<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/12/18
 * Time: 17.54
 */

require_once "../lib/start.php";
require_once "../lib/Venue.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$name = null;
$code = null;
$vid = $_POST['vid'];

if($_POST['action'] == ACTION_INSERT || $_POST['action'] == ACTION_UPDATE ){
	$name =  $db->real_escape_string($_POST['venue']);
	$code = $_POST['code'];
	$venue = new \elibrary\Venue($vid, $name, $code, new MySQLDataLoader($db));
}
else{
	$venue = new \elibrary\Venue($vid, null, null, new MySQLDataLoader($db));
}

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case ACTION_INSERT:
		try{
			$begin = $db->executeUpdate("BEGIN");
			//$db->executeUpdate("INSERT INTO rb_venues (name) VALUE ('{$name}')");
			$venue->insert();
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
		$msg = "Plesso inserito";
		break;
	case ACTION_DELETE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			//$db->executeUpdate("DELETE FROM rb_venues WHERE vid = {$vid}");
			$venue->delete();
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
		$msg = "Sede eliminata";
		break;
	case ACTION_UPDATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			//$db->executeUpdate("UPDATE rb_venues SET name = '{$name}' WHERE vid = {$vid}");
			$venue->update();
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Sede aggiornata";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;
