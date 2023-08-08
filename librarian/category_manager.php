<?php

require_once "../lib/start.php";

check_session(AJAX_CALL);

$cat_id = $_POST['cid'];
if ($_POST['action'] == ACTION_INSERT || $_POST['action'] == ACTION_UPDATE) {
	$name =  $db->real_escape_string($_POST['category']);
    $code =  $db->real_escape_string($_POST['code']);
    $code = strtoupper($code);
}

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch ($_POST['action']) {
	case ACTION_INSERT:
		try {
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("INSERT INTO rb_categories (category, code) VALUES ('{$name}', '$code')");
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
		$msg = "Categoria inserita";
		break;
	case ACTION_DELETE:
		try {
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("DELETE FROM rb_categories WHERE cid = {$cat_id}");
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
		$msg = "Categoria eliminata";
		break;
	case ACTION_UPDATE:
		try {
			$begin = $db->executeUpdate("BEGIN");
			$db->executeUpdate("UPDATE rb_categories SET category = '{$name}', code = '$code' WHERE cid = {$cat_id}");
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex) {
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = substr($ex->getMessage(), 135);
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Categoria aggiornata";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;