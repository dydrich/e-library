<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/12/18
 * Time: 17.22
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$sel_venues = "SELECT * FROM rb_venues ORDER BY name";

try {
	$res_venues = $db->executeQuery($sel_venues);
} catch (MySQLException $ex) {

}

$venues = [];
$colors = ['#0288d1', '#00796b', '#c62828', '#8e24aa', '#303f9f'];
$k = 0;
while ($row = $res_venues->fetch_assoc()) {
	$rooms = $db->executeCount("SELECT COUNT(*) FROM rb_rooms WHERE vid = {$row['vid']}");
	$venues[$row['vid']] = ['vid' => $row['vid'], 'venue' => $row['name'], 'rooms' => $rooms, 'color' => $colors[$k]];
	$k++;
}

$_SESSION['venues'] = $venues;

$drawer_label = "Sedi scolastiche";

include "school_complexes.html.php";