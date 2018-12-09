<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 10.14
 */
require_once "../lib/start.php";
require_once "../lib/SchoolClass.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$year = $section = $start = null;
if($_POST['action'] == ACTION_INSERT || $_POST['action'] == ACTION_UPDATE ){
	$year = $_POST['year'];
	$section = $db->real_escape_string($_POST['section']);
	$start = $_POST['start'];
}
$cid = $_POST['cid'];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case ACTION_INSERT:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$school_class = new SchoolClass($cid, $year, $section, new MySQLDataLoader($db), $start, 1);
			$school_class->insert();
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
		$msg = "Classe inserita";
		break;
	case ACTION_DELETE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$school_class = new SchoolClass($cid, null, null, new MySQLDataLoader($db), null, 0);
			$school_class->delete();
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
		$msg = "Classe eliminata";
		break;
	case ACTION_DEACTIVATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$school_class = new SchoolClass($cid, null, null, new MySQLDataLoader($db), null, 0);
			$school_class->deactivate();
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
		$msg = "Classe disattivata";
		break;
	case ACTION_RESTORE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$school_class = new SchoolClass($cid, null, null, new MySQLDataLoader($db), null, 0);
			$school_class->restore();
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
		$msg = "Classe attivata";
		break;
	case ACTION_UPDATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$school_class = new SchoolClass($cid, $year, $section, new MySQLDataLoader($db), $start, 1);
			$school_class->update();
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Classe aggiornata";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;
