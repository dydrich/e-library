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

$res_students = $db->executeQuery("SELECT * FROM rb_users WHERE class = {$_REQUEST['cid']} ORDER BY lastname, firstname");
$r = $db->executeQuery("SELECT * FROM rb_classes WHERE cid = ".$_GET['cid']);
$res = $r->fetch_assoc();
$class = new SchoolClass($_GET['cid'], $res['year'], $res['section'], new MySQLDataLoader($db), $res['start'], $res['active']);

$drawer_label = "Elenco studenti";

include "class_students.html.php";