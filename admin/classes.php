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

$have_content = 1;

$active = " WHERE active = 1 ";
if (!isset($_GET['active'])) {
	$active = "";
}
else {
	$active = " WHERE active = {$_GET['active']}";
}
$sel_noclass_students = "SELECT COUNT(*) FROM rb_users JOIN rb_user_roles ON rb_users.uid=rb_user_roles.uid 
						WHERE rid = 3 AND class IS NULL AND active = 1";

try {
	$res_classes = $db->executeQuery("SELECT * FROM rb_classes $active ORDER BY section, year");
	//$noclass_students = $db->executeCount($sel_noclass_students);
} catch (MySQLException $ex) {

}

$nav_link = "classes.php";
$nav_final_letter = "e";

$drawer_label = "Classi";

include "classes.html.php";