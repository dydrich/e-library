<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 27/05/18
 * Time: 17.58
 */

require_once './lib/start.php';
require_once './lib/RBUtilities.php';
require_once './lib/AccountManager.php';
require_once './lib/User.php';

if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'reactivate'){
	$_SESSION['activation_message'] = 'activation_code_sent';
	$uid = $_SESSION['user_act'];
	$username = $db->executeCount("SELECT username FROM rb_users WHERE uid = $uid");
	$user = new \edocs\User($_SESSION['user_act'], '', '', $username, '', \edocs\User::$GUEST, new MySQLDataLoader($db));
	$user->sendActivationEmail();
	header("Location: ".ROOT_SITE."/activation_page.php");
}

$token = $_REQUEST['token'];
$uid = $_REQUEST['chk'];
$res = $db->executeQuery("SELECT active, code_expire_time FROM rb_users WHERE activation_code = '{$token}' AND uid = '{$uid}'");

if ($res->num_rows > 0) {
	$expire_date = $res->fetch_assoc();
	if($expire_date['active'] == 1) {
		$_SESSION['activation_message'] = 'account_already_activated';
		$_SESSION['user_act'] = $uid;
	}
	else if($expire_date['code_expire_time'] < date("Y-m-d H:i:s")) {
		$_SESSION['user_act'] = $uid;
		$_SESSION['activation_message'] = 'code_expired';
	}
	else {
		$db->executeUpdate("UPDATE rb_users SET active = 1 WHERE uid = $uid");
		$_SESSION['user_act'] = $uid;
		$_SESSION['activation_message'] = 'account_activated';
	}
}
else {
	$_SESSION['user_act'] = $uid;
	$_SESSION['activation_message'] = 'code_expired';
}


header("Location: ".ROOT_SITE."/activation_page.php");