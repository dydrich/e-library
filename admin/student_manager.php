<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 23/12/18
 * Time: 10.18
 */
require_once "../lib/start.php";

check_session(AJAX_CALL);

$cid = $_POST['cid'];
$student = $_POST['student'];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case 'move_student':
		try{
			$begin = $db->executeUpdate("BEGIN");
			if($cid !=  0) {
				$db->executeUpdate("UPDATE rb_users SET class = {$cid} WHERE uid = {$student}");
			}
			else {
				$db->executeUpdate("UPDATE rb_users SET class = NULL WHERE uid = {$student}");
			}
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore SQL";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Operazione eseguita";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;