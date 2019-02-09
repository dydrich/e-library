<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/12/18
 * Time: 18.07
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$filter = '';
if (isset($_GET['vid'])) {
	$filter = 'WHERE vid = '.$_GET['vid'];
}

$sel_rooms = "SELECT * FROM rb_rooms $filter ORDER BY vid, name";
$sel_venues = "SELECT * FROM rb_venues $filter ORDER BY name";
try {
	$res_rooms = $db->executeQuery($sel_rooms);
	$res_venues = $db->executeQuery($sel_venues);
} catch (MySQLException $ex) {

}

$venues = [];
while ($r = $res_venues->fetch_assoc()) {
	$venues[$r['vid']] = ['venue' => $r['name'], 'rooms' => []];
}
while ($rr = $res_rooms->fetch_assoc()) {
	$venues[$rr['vid']]['rooms'][] = $rr;
}

$drawer_label = "Locali libreria";

include "rooms.html.php";