<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 10.13
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$active = " WHERE active = 1 ";
if (!isset($_GET['active'])) {
	$active = "";
}
else {
	$active = " WHERE active = {$_GET['active']}";
}

$res_classes = $db->executeQuery("SELECT * FROM rb_classes $active ORDER BY section, year");

$drawer_label = "Classi";

include "classes.html.php";