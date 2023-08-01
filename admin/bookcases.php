<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/01/19
 * Time: 19.18
 */
require_once "../lib/start.php";

ini_set('display_errors', 1);

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$filter = $filter_room = $room = '';
if (isset($_GET['rid'])) {
	$filter = 'AND room = '.$_GET['rid'];
	$filter_room = " WHERE rid = ".$_GET['rid'];
}

$sel_rooms = "SELECT * FROM rb_rooms $filter_room ORDER BY vid, name";
$sel_venues = "SELECT * FROM rb_venues ORDER BY name";
try {
	$res_rooms = $db->executeQuery($sel_rooms);
	$res_venues = $db->executeQuery($sel_venues);
} catch (MySQLException $ex) {
	$ex->__toString();
}

$venues = [];
$rooms = [];
while ($r = $res_venues->fetch_assoc()) {
	$venues[$r['vid']] = ['venue' => $r['name'], 'bookcases' => []];
}
while ($rr = $res_rooms->fetch_assoc()) {
	$rooms[$rr['rid']] = $rr['name'];
}

$sel_bookcases = "SELECT rb_bookcases.*, rb_rooms.vid AS vid FROM rb_bookcases, rb_rooms, rb_venues WHERE rb_rooms.vid = rb_venues.vid AND rid = room $filter ORDER BY room, bid";
try {
	$res_bookcases = $db->executeQuery($sel_bookcases);
	if (isset($_GET['rid'])) {
		$room = $db->executeCount("SELECT name FROM rb_rooms WHERE rid = {$_GET['rid']}");
	}
} catch (MySQLException $ex) {
	$ex->__toString();
}

$bookcases = [];
if ($res_bookcases->num_rows > 0) {
	while ($row = $res_bookcases->fetch_assoc()) {
		$row['room_desc'] = $rooms[$row['room']];
		$bookcases[] = $row;
		$venues[$row['vid']]['bookcases'][$row['bid']] = $row;
	}
}

$drawer_label = "Armadi $room";

include 'bookcases.html.php';