<?php
/**
 * Created by VSCode.
 * User: riccardo
 * Date: 08/10/23
 * Time: 11:20
 */

require_once "lib/start.php";
require_once "lib/load_env.php";
require_once "lib/Mobile_Detect.php";

if(isset($_SESSION['__user__'])) {
	header("Location: welcome.php");
}

ini_set('display_errors', 1);

$drawer_label = "Conferma la richiesta";
$detect = new Mobile_Detect;

$student = $_GET['sid'];

$r_users = $db->executeQuery("SELECT rb_users.* FROM rb_users WHERE rb_users.uid = {$student}");
$_user = $r_users->fetch_assoc();
$r_class = $db->executeQuery("SELECT * FROM rb_classes WHERE cid = {$_user['class']}");
$_class = $r_class->fetch_assoc();

include "confirm_request.html.php";