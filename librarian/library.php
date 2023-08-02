<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 25/12/18
 * Time: 10.51
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$LIBRARIAN);
check_role($user, User::$LIBRARIAN);

$_SESSION['area'] = 'librarian';

$sel_books = "SELECT * FROM rb_books ORDER BY author, title";
$res_books = $db->executeQuery($sel_books);

$drawer_label = "Libreria";

include "library.html.php";