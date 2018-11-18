<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 11.20
 */
require_once "../lib/start.php";

check_session();
check_role(\edocs\User::$ADMIN);

$_SESSION['area'] = 'admin';
$drawer_label = null;
if ($_GET['sid'] == 0) {
	$drawer_label = "Nuova variabile";
}
else {
	$drawer_label = "Modifica variabile";
}

include "setting.html.php";