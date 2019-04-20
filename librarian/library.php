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

$drawer_label = "Libreria";

include "library.html.php";