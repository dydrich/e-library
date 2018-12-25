<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 09/10/17
 * Time: 21.37
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$LIBRARIAN);
check_role($user, User::$LIBRARIAN);

$_SESSION['area'] = 'libt=rarian';

$drawer_label = "Dashboard";

include "index.html.php";