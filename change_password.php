<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 30/12/13
 * Time: 18.52
 */

require_once './lib/start.php';
require_once './lib/RBUtilities.php';
require_once './lib/AccountManager.php';

if(!isset($_SESSION['__config__'])){
	include_once "lib/load_env.php";
}

$token = $_GET['token'];
$today = date("Y-m-d H:i:s");
$due = false;

$sel_token = "SELECT token_due_date, user FROM rb_password_recovery WHERE token = '{$token}'";
$res_token = $db->executeQuery($sel_token);
$token = $res_token->fetch_assoc();
if ($token['token_due_date'] < $today){
	$due = true;
	$token = null;
	$area = 0;
	$uid = 0;
}
else {
	$uid = $token['user'];
}

include "change_password.html.php";

