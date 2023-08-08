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

$sel_categories = "SELECT rb_categories.*, COUNT(rb_categories_book._id) as books FROM rb_categories LEFT JOIN rb_categories_book ON rb_categories.cid = rb_categories_book.cid GROUP BY cid, category, code ORDER BY category";
$res = $db->executeQuery($sel_categories);

$drawer_label = "Categorie libri";

include "categories.html.php";