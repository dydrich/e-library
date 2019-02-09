<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/12/18
 * Time: 17.35
 */
require_once "../lib/start.php";

ini_set('display_errors', 1);

check_session();

$_SESSION['area'] = 'admin';
$drawer_label = null;
if ($_GET['vid'] == 0) {
	$drawer_label = "Nuova sede";
	$res = null;
}
else {
	$drawer_label = "Modifica sede";
	$r = $db->executeQuery("SELECT * FROM rb_venues WHERE vid = ".$_GET['vid']);
	$res = $r->fetch_assoc();
}

include 'school_complex.html.php';