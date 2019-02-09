<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/12/18
 * Time: 17.07
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$sel_venues = "SELECT * FROM rb_venues ORDER BY name";

try {
	$res_venues = $db->executeQuery($sel_venues);
	$count_venues = $db->executeCount('SELECT COUNT(*) FROM rb_venues');
	$count_rooms = $db->executeCount('SELECT COUNT(*) FROM rb_rooms');
} catch (MySQLException $ex) {

}

$venues = [];
$colors = ['#0288d1', '#00796b', '#c62828', '#8e24aa', '#303f9f'];
$k = 0;
while ($row = $res_venues->fetch_assoc()) {
	$venues[$row['vid']] = ['vid' => $row['vid'], 'venue' => $row['name'], 'color' => $colors[$k]];
	$k++;
}

$_SESSION['venues'] = $venues;

$drawer_label = "Librerie";

include "libraries.html.php";