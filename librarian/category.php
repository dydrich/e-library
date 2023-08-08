<?php
/**
 * Created by VSCode.
 * User: riccardo
 * Date: 08/08/23
 * Time: 11.58
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$LIBRARIAN);
check_role($user, User::$LIBRARIAN);

$_SESSION['area'] = 'librarian';

$drawer_label = "<a href='categories.php' style='font-size: 1em'>Categorie</a> :: ";
if ($_GET['cid'] == 0) {
	$drawer_label .= "Nuova categoria";
	$res = null;
}
else {
	$drawer_label .= "Modifica categoria";
	$r = $db->executeQuery("SELECT * FROM rb_categories WHERE cid = ".$_GET['cid']);
	$res = $r->fetch_assoc();
}

include "category.html.php";