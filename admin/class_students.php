<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 09/12/18
 * Time: 20.01
 */
require_once "../lib/start.php";
require_once "../lib/SchoolClass.php";

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';
$class = null;
if ($_REQUEST['cid'] != 0) {
	$sel_students = "SELECT * FROM rb_users WHERE class = {$_REQUEST['cid']} ORDER BY lastname, firstname";
}
else {
	$sel_students = "SELECT * FROM rb_users JOIN rb_user_roles ON rb_users.uid=rb_user_roles.uid 
					WHERE rid = 3 AND class IS NULL AND active = 1";
}
try {
	$res_students = $db->executeQuery($sel_students);
	if ($_REQUEST['cid'] != 0) {
		$r = $db->executeQuery("SELECT * FROM rb_classes WHERE cid = ".$_GET['cid']);
		$res = $r->fetch_assoc();
		$class = new SchoolClass($_GET['cid'], $res['year'], $res['section'], new MySQLDataLoader($db), $res['start'], $res['active']);
	}
	else {
		$class = new SchoolClass(0, 'AS', 'C', new MySQLDataLoader($db), null, 1);
	}
	$res_classes = $db->executeQuery("SELECT * FROM rb_classes WHERE active = 1 ORDER BY section, year");
} catch (MySQLException $ex) {

}

$drawer_label = "Elenco studenti";

include "class_students.html.php";