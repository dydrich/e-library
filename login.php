<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 08/10/17
 * Time: 16.48
 */

ini_set("display_errors", 1);
require_once "lib/start.php";

if (isset($_SESSION['__user__'])) {
	if ($_REQUEST['area'] == 'admin'){
		if ($_SESSION['__user__']->getRole() != \edocs\User::$ADMIN) {
			// TODO: no_permission page
		}
		else {
			header("Location: admin/index.php");
		}
	}
	else if ($_REQUEST['area'] == 'private'){
		if ($_SESSION['__user__']->getRole() != \edocs\User::$USER) {
			// TODO: no_permission page
		}
		else {
			header("Location: back/index.php");
		}
	}
}

include "login.html.php";