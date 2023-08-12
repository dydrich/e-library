<?php

/**
 * inizio della gestione unificata via classe dei documenti, con creazione, modifica e cancellazione
 * si parte con la cancellazione degli allegati al registro docente 
 */

require_once "../lib/start.php";

check_session();

ini_set('display_errors', 1);

$response = array("status" => "ok");
header("Content-type: application/json");

if ($_POST['action'] == "delete") {
	// quick delete
	$f = $_POST['server_file'];
	$id = $_REQUEST['id'];
	$fp = "download/{$t}/";
	$doc = new Document($id, null, new MYSQLDataLoader($db));
	$doc->setFile($f);
	$doc->setFilePath($fp);
	$doc->setDocumentType($t);
	/*
	if (!$doc->deleteFile()) {
		$response['status'] = "ko";
		$response['message'] = "File non trovato";
		$response['dbg_message'] =
		$res = json_encode($response);
		echo $res;
		exit;
	}
	*/
	$doc->delete();
	$response['message'] = "Il file è stato cancellato";
	$res = json_encode($response);
	echo $res;
	exit;
}
