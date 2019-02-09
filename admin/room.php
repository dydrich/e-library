<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/12/18
 * Time: 18.21
 */
require_once "../lib/start.php";

ini_set('display_errors', 1);

check_session();

$_SESSION['area'] = 'admin';
$drawer_label = null;
if ($_GET['rid'] == 0) {
	$drawer_label = "Nuovo locale";
	$res = null;
}
else {
	$drawer_label = "Modifica locale";
	$r = $db->executeQuery("SELECT * FROM rb_rooms WHERE rid = ".$_GET['rid']);
	$res = $r->fetch_assoc();
}

$res_venues = $db->executeQuery("SELECT * FROM rb_venues ORDER BY name");

include "room.html.php";