<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 24/10/17
 * Time: 7.16
 */
require_once "../lib/start.php";

ini_set('display_errors', 1);

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';
$drawer_label = null;
$exclude = null;
if ($_GET['_id'] == 0) {
	$drawer_label = "Nuovo anno";
}
else {
	$drawer_label = "Modifica anno";
	$exclude = "WHERE _id != ".$_GET['_id'];
	$res = $db->executeQuery("SELECT * FROM rb_years WHERE _id = ".$_GET['_id']);
	$year = $res->fetch_assoc();
}

$res_years = $db->executeQuery("SELECT * FROM rb_years $exclude ORDER BY description");

include "year.html.php";