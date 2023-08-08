<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 09/10/17
 * Time: 21.37
 */
require_once "../lib/start.php";

ini_set("display_errors", 1);

check_session();
$user->setCurrentRole(User::$LIBRARIAN);
check_role($user, User::$LIBRARIAN);

$_SESSION['area'] = 'librarian';

$drawer_label = "Dashboard";

include "index.html.php";