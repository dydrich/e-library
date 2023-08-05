<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/12/18
 * Time: 18.07
 */
require_once "../lib/start.php";

ini_set('display_errors', 1);

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
while ($v = $res_venues->fetch_assoc()) {
	$venues[$v['vid']] = ['venue' => $v['name']];
}
$rooms = [];
while ($r = $res_rooms->fetch_assoc()) {
	$rooms[$r['rid']] = ['room' => $r['name'], 'vid' => $r['vid'], 'venue' => $venues[$r['vid']]];
}

$drawer_label = "Locali libreria";

include "rooms.html.php";