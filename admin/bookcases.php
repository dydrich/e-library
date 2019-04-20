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

$filter = '';
if (isset($_GET['rid'])) {
	$filter = 'WHERE room = '.$_GET['rid'];
}

$sel_bookcases = "SELECT * FROM rb_bookcases $filter ORDER BY room, bid";
try {
	$res_bookcases = $db->executeQuery($sel_bookcases);
	$room = $db->executeCount("SELECT name FROM rb_rooms WHERE rid = {$_GET['rid']}");
} catch (MySQLException $ex) {

}

$bookcases = [];
if ($res_bookcases->num_rows > 0) {
	while ($row = $res_bookcases->fetch_assoc()) {
		$bookcases[] = $row;
	}
}

$drawer_label = "Armadi $room";

include 'bookcases.html.php';