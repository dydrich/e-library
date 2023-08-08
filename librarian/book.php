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
$book = null;

try {
	$res_bookcases = $db->executeQuery($sel_bookcases);
	$res_rooms = $db->executeQuery($sel_rooms);
	if($_REQUEST['book_id'] != 0) {
		$res_book = $db->executeQuery("SELECT * FROM rb_books WHERE bid = ".$_REQUEST['book_id']);
		$_book = $res_book->fetch_assoc();
		$location = ['school_complex' => $_book['school_complex'], 'room' => $_book['room'], 'bookcase' => $_book['bookcase'], 'shelf' => $_book['shelf']];
		$book = new \elibrary\Book($_REQUEST['book_id'], $_book['title'], $_book['author'], $_book['publisher'], $_book['first_edition'], $_book['book_year'], $_book['pages'], $location, new MySQLDataLoader($db));
	}
	else {
		$book = new \elibrary\Book($_REQUEST['book_id'], null, null, null, null, null, null, [], new MySQLDataLoader($db));
		$location = ['school_complex' => '', 'room' => '', 'bookcase' => '', 'shelf' => ''];
	}
} catch(MySQLException $ex) {

}

$drawer_label = "Nuovo libro";

include "book.html.php";
