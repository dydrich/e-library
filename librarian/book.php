<?php

require_once "../lib/start.php";
require_once "../lib/Book.php";

ini_set('display_errors', 1);

check_session();
$user->setCurrentRole(User::$LIBRARIAN);
check_role($user, User::$LIBRARIAN);

$_SESSION['area'] = 'librarian';

$sel_rooms = "SELECT rb_rooms.*, rb_venues.name AS venue FROM rb_rooms, rb_venues WHERE rb_rooms.vid=rb_venues.vid AND bookcases > 0 ORDER BY rb_rooms.vid, name";
$sel_bookcases = "SELECT * FROM rb_bookcases ORDER BY room, bid";
$sel_categories = "SELECT * FROM rb_categories ORDER BY category";
$book = null;

try {
	$res_bookcases = $db->executeQuery($sel_bookcases);
	$res_rooms = $db->executeQuery($sel_rooms);
	$res_categories = $db->executeQuery($sel_categories);
	if($_REQUEST['book_id'] != 0) {
		$archive = Archive::getInstance(new MySQLDataLoader($db));
		$book = archive->getBookFromId($_REQUEST['book_id']);
		$location = $book->getLocation();
	}
	else {
		$book = new \elibrary\Book($_REQUEST['book_id'], null, null, null, null, null, null, [], new MySQLDataLoader($db), null);
		$location = ['school_complex' => '', 'room' => '', 'bookcase' => '', 'shelf' => ''];
	}
} catch(MySQLException $ex) {

}

$drawer_label = "Nuovo libro";

include "book.html.php";
