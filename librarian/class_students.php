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
$user->setCurrentRole(User::$LIBRARIAN);
check_role($user, User::$LIBRARIAN);

$_SESSION['area'] = 'librarian';
$class = null;
$sel_students = "SELECT rb_users.*, rb_user_roles.rid FROM rb_users, rb_user_roles WHERE rb_users.uid = rb_user_roles.uid AND class = {$_REQUEST['cid']} ORDER BY lastname, firstname";

try {
	$res_students = $db->executeQuery($sel_students);
	$r = $db->executeQuery("SELECT * FROM rb_classes WHERE cid = ".$_GET['cid']);
	$res = $r->fetch_assoc();
	$class = new SchoolClass($_GET['cid'], $res['year'], $res['section'], new MySQLDataLoader($db), $res['start'], $res['active']);
	$class->setPersonInCharge($res['charged']);
	$res_classes = $db->executeQuery("SELECT * FROM rb_classes WHERE active = 1 ORDER BY section, year");
} catch (MySQLException $ex) {

}

$drawer_label = "<a href='classes.php' style='font-size: 1em'>Classi</a> :: Elenco studenti ".$res['year'].$res['section'];

include "class_students.html.php";