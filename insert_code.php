<?php

require_once "lib/start.php";
require_once "lib/load_env.php";
require_once "lib/Mobile_Detect.php";
require_once "lib/RBUtilities.php";

if(isset($_SESSION['__user__'])) {
	header("Location: welcome.php");
}

ini_set('display_errors', 1);

$drawer_label = "Conferma la richiesta";
$detect = new Mobile_Detect;

$rb = RBUtilities::getInstance($db);
$student = $rb->loadUserFromUid($_REQUEST['sid']);

include "insert_code.html.php";