<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 09/02/19
 * Time: 10.00
 */
require_once "../lib/start.php";

ini_set('display_errors', 1);

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$bookcase = null;
if (!isset($_GET['bid']) || $_GET['bid'] == 0) {
	$bookcase = null;
}
else {
	$sel_bookcase = "SELECT * FROM rb_bookcases WHERE bid = ".$_GET['bid'];
	try {
		$res_bookcase = $db->executeQuery($sel_bookcase);
		$filter = '';
		if (isset($_GET['rid'])) {
			$room = $db->executeCount("SELECT name FROM rb_rooms WHERE rid = {$_GET['rid']}");
		}
	} catch (MySQLException $ex) {
	
	}
	$bookcase = $res_bookcase->fetch_assoc();
}

$filter = '';
if (isset($_GET['rid'])) {
	$filter = 'AND rid = '.$_GET['rid'];
}
$sel_rooms = "SELECT rb_rooms.*, rb_venues.name AS venue FROM rb_rooms, rb_venues WHERE rb_rooms.vid=rb_venues.vid ORDER BY rb_rooms.vid, name";
try {
	$res_rooms = $db->executeQuery($sel_rooms);
} catch (MySQLException $ex) {

}

if ($_GET['bid'] == 0) {
	$drawer_label = "Armadio";
	try {
		$progressive = $db->executeCount("SELECT COALESCE(MAX(bid), 0) FROM `rb_bookcases`");
	} catch (MySQLException $ex) {
	
	}
	$progressive++;
}
else {
	$drawer_label = "Modifica armadio";
	$progressive = $_GET['bid'];
}

if (isset($_GET['rid'])) {
	try {
		$rid_name = $db->executeCount("SELECT name FROM rb_rooms WHERE rid = ".$_GET['rid']);
	} catch (MySQLException $ex) {
	
	}
	$drawer_label .= " ".$rid_name;
}

include 'bookcase.html.php';