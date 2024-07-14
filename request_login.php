<?php
/**
 * Created by VSCode.
 * User: riccardo
 * Date: 08/10/23
 * Time: 09:45
 */

require_once "lib/start.php";
require_once "lib/load_env.php";
require_once "lib/Mobile_Detect.php";

if(isset($_SESSION['__user__'])) {
	header("Location: welcome.php");
}

ini_set('display_errors', 1);

$drawer_label = "Richiedi l'accesso al servizio";
$detect = new Mobile_Detect;

$r_users = $db->executeQuery("SELECT rb_users.* FROM rb_users, rb_user_roles WHERE rb_users.uid = rb_user_roles.uid AND rid = 3 AND active = 0 ORDER BY lastname, firstname");

include "request_login.html.php";