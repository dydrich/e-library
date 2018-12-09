<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 21/11/18
 * Time: 18.19
 */
require_once "lib/start.php";
check_session();

ini_set('display_errors', 1);

$drawer_label = "Welcome";

$user->setRoles();
$roles = $user->getRoles();
/*
$res = $db->executeQuery('SELECT rid FROM rb_user_roles WHERE uid = '.$user->getUid());
$roles = [];
while ($r = $res->fetch_assoc()) {
	$roles[] = $r['rid'];
}
*/

$colors = array("9c27b0", "3f51b5", "009688", "ff9800", "64dd17", "fdd835");
$links = array("admin/index.php", "librarian/index.php", "class_librarian/index.php", "student/index.php");
$labels = array("amministratore", "bibliotecario", "bibliotecario di classe", "studente");
$icons = array('build', 'person', 'group', 'school');

include "welcome.html.php";