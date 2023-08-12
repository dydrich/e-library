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

$sel_books = "SELECT bid, author, title, COALESCE(cover, 'blankbook_th.jpg') AS cover FROM rb_books ORDER BY title";
$res_books = $db->executeQuery($sel_books);

$covers_home = "../images/covers/";

$drawer_label = "Catalogo libri";

include "library.html.php";