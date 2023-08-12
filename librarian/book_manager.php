<?php

require_once "../lib/start.php";
require_once "../lib/Book.php";
require_once "../lib/Archive.php";

ini_set('display_errors', 1);

check_session(AJAX_CALL);

$room = $bookcase = $shelf = $author = $title = $publisher = null;
$book_id = $_POST['book_id'];
if ($_POST['action'] == ACTION_INSERT || $_POST['action'] == ACTION_UPDATE) {
	$title =  $db->real_escape_string($_POST['title']);
	$author =  $db->real_escape_string($_POST['author']);
	$publisher =  $db->real_escape_string($_POST['publisher']);
	$bookcase = $_POST['bookcase'];
	$room = $_POST['room'];
	$school_complex = $db->executeCount("SELECT vid FROM rb_rooms WHERE rid = {$room}");
	$shelf = $_POST['shelf'];
	$location = ['school_complex' => $school_complex, 'room' => $room, 'bookcase' => $bookcase, 'shelf' => $shelf];
	$book = new \elibrary\Book($book_id, $title, $author, $publisher, null, null, null, $location, new MySQLDataLoader($db));
}
else if ($_POST['action'] == ACTION_DELETE){
	$book = new \elibrary\Book($book_id, null, null, null, null, null, null, [], new MySQLDataLoader($db));
}

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch ($_POST['action']) {
	case ACTION_INSERT:
		try {
			$begin = $db->executeUpdate("BEGIN");
			$book->insert();
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
		$msg = "Libro inserito";
		break;
	case ACTION_DELETE:
		try {
			$begin = $db->executeUpdate("BEGIN");
			$book->delete();
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
		$msg = "Libro eliminato";
		break;
	case ACTION_UPDATE:
		try {
			$begin = $db->executeUpdate("BEGIN");
			$book->update();
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex) {
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Libro aggiornato";
		break;
	case ACTION_UNLOAD_FILE:
		$file = $_POST['server_file'];
		$dir = $_SESSION['__config__']['document_root']."/images/covers/";
		$path = $dir.$file;
		try {
			if (file_exists($path)){
				unlink($path);
			}
			else {
				$response['status'] = "kofile";
				$response['message'] = "File non trovato";
				$response['dbg_message'] = "Non è stato possibile completare l'operazione perché il file {$file} non si trova nella posizione indicata";
				$response['dir'] = $dir;
				echo json_encode($response);
				exit;
			}
		} catch (Exception $ex) {
			$response['status'] = "ko";
			$response['message'] = "Operazione non completata";
			$response['dbg_message'] = $ex->getMessage();
			$response['dir'] = $dir.$file;
			echo json_encode($response);
			exit;
		}
	case ACTION_GET_BOOK_CODE:
		$id = $_REQUEST['book_id'];
		$cat = $_REQUEST['cat'];
		$archive = \elibrary\Archive::getInstance(new MySQLDataLoader($db));
		$code = $archive->getBookCode($id, $cat);
		$response['code'] = $code;
		$msg = "";
	break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;