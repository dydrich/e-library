<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 08/10/17
 * Time: 11.52
 */

ini_set("display_errors", 1);

require_once "lib/start.php";
require_once "lib/Authenticator.php";
//require_once "lib/EventLogFactory.php";

header("Content-type: application/json");

$nick = $db->real_escape_string($_POST['my-username']);
$pass = $db->real_escape_string($_POST['pw']);
$pwd = md5($pass);

$authenticator = new Authenticator(new MySQLDataLoader($db));
try {
	$user = $authenticator->login($nick, $pwd);
} catch (\edocs\MySQLException $ex){
	$response['status'] = "kosql";
	$response['query'] = $ex->getQuery();
	$response['message'] = $ex->getMessage();
	$_SESSION['mysqlerror'] = $response;
	$res = json_encode($response);
	echo $res;
	exit;
} catch (\edocs\CustomException $e){
	$response['status'] = "ko";
	$response['message'] = $e->getMessage();
	$response['code'] = $e->getCode();
	$response['detail'] = $e->__toString();
	$_SESSION['error'] = $response;
	$res = json_encode($response);
	echo $res;
	exit;
}

if ($user == null) {
	$response['status'] = "kologin";
	$response['message'] = "Username o password errata";
	$response['code'] = $e->getCode();
	$response['detail'] = $e->__toString();
	$_SESSION['error'] = $response;
	$res = json_encode($response);
	echo $res;
	exit;
}

$_SESSION['__user__'] = $user;
$response = $authenticator->getResponse();
$response["status"] = "ok";
$response['role'] = $user->getRole();
$res = json_encode($response);
echo $res;
exit;
