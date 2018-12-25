<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 10.13
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$LIBRARIAN);
check_role($user, User::$LIBRARIAN);

$_SESSION['area'] = 'librarian';

$active = " WHERE active = 1 ";
if (!isset($_GET['active'])) {
	$active = "";
}
else {
	$active = " WHERE active = {$_GET['active']}";
}

try {
	$res_classes = $db->executeQuery("SELECT * FROM rb_classes $active ORDER BY section, year");
} catch (MySQLException $ex) {

}

$drawer_label = "Classi";

include "classes.html.php";