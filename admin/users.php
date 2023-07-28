<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 11/10/17
 * Time: 22.12
 */
require_once "../lib/start.php";
require_once "../lib/User.php";

check_session();

ini_set('display_errors', 1);

$active = " WHERE active = 1 ";
if (!isset($_GET['active'])) {
	$active = " WHERE uid != 1";
}
else {
	$active = " WHERE active = {$_GET['active']} AND uid != 1";
}

$r_users = null;
try {
	$r_users = $db->executeQuery("SELECT * FROM rb_users $active ORDER BY lastname, firstname");
	$users = [];
	if ($r_users->num_rows > 0) {
		while ($row = $r_users->fetch_assoc()) {
			$rs = $db->executeQuery("SELECT rid FROM rb_user_roles WHERE uid = ".$row['uid']);
			$row['role'] = null;
			$row['person_in_charge'] = null;
			while ($r = $rs->fetch_assoc()) {
				if ($r['rid'] != 3) {
					$row['role'] = $r['rid'];
				}
				else {
					$row['person_in_charge'] = 1;
				}
			}
			$users[] = $row;
		}
	}
} catch (MySQLException $ex) {
	$ex->redirect();
}

$nav_link = "users.php";
$nav_final_letter = "i";

$drawer_label = "Utenti";

include "users.html.php";