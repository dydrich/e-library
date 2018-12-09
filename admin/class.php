<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 10.14
 */
require_once "../lib/start.php";
require_once "../lib/SchoolClass.php";

ini_set('display_errors', 1);

check_session();

$_SESSION['area'] = 'admin';
$drawer_label = null;
$exclude = null;
if ($_GET['cid'] == 0) {
	$drawer_label = "Nuova classe";
}
else {
	$drawer_label = "Modifica classe";
	$exclude = "WHERE cid != ".$_GET['cid'];
	$r = $db->executeQuery("SELECT * FROM rb_classes WHERE cid = ".$_GET['cid']);
	$res = $r->fetch_assoc();
	$class = new SchoolClass($_GET['cid'], $res['year'], $res['section'], new MySQLDataLoader($db), $res['start'], $res['active']);
}

$res_classes = $db->executeQuery("SELECT * FROM rb_classes ORDER BY section, year");
$res_years = $db->executeQuery("SELECT * FROM rb_years ORDER BY `_id`");
$sections = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
$levels = [1, 2, 3];

include "class.html.php";