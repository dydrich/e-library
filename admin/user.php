<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 12/10/17
 * Time: 18.45
 */
require_once "../lib/start.php";
require_once '../lib/User.php';

check_session();

ini_set('display_errors', 1);

if ($_REQUEST['uid'] == 0) {
	$drawer_label = 'Nuovo utente';
}
else {
	$drawer_label = "Modifica utente";
	$r_us = $db->executeQuery("SELECT * FROM rb_users WHERE uid = ".$_REQUEST['uid']);
	$r_rl = $db->executeQuery("SELECT rid FROM rb_user_roles WHERE uid = ".$_REQUEST['uid']);
	$roles = [];
	while ($r = $r_rl->fetch_assoc()) {
		$roles[] = $r['rid'];
	}
	if ($r_us) {
		$us = $r_us->fetch_assoc();
		$_user = new User($_REQUEST['uid'], $us['firstname'], $us['lastname'], $us['username'], null, $roles, new MySQLDataLoader($db));
	}
}

$res_roles = $db->executeQuery("SELECT * FROM rb_roles");

include "user.html.php";