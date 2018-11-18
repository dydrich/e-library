<?php

require_once "User.php";
require_once "functions.lib.php";
require_once "database.lib.php";
require_once "define.php";
require_once "MySQLException.php";
require_once "data_source.php";

session_start();

require_once 'conn.php';

$page = $_SERVER['SCRIPT_FILENAME'];
$ip = $_SERVER['REMOTE_ADDR'];
$uid = 0;
$role = 0;
$uri = $_SERVER['SCRIPT_NAME'];
if(isset($_SESSION['__user__'])){
	$uid = $_SESSION['__user__']->getUid();
	$role = $_SESSION['__user__']->getRole();
}

//$ins = "INSERT INTO rb_visits (access_ts, ip_address, page, uid, uri) VALUES (NOW(), '{$ip}', '{$page}', {$uid}, '{$uri}')";
//$r_ins = $db->executeUpdate($ins);

ini_set("default_charset", "utf-8");

/*
 * default theme
 */
//$id_theme = $db->executeCount("SELECT value FROM rb_settings WHERE var = 'theme'");
//$_SESSION['default_theme'] = $db->executeCount("SELECT directory FROM rb_themes WHERE id_tema = {$id_theme}");

date_default_timezone_set("Europe/Rome");
