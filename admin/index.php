<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 09/10/17
 * Time: 21.37
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$drawer_label = "Dashboard";

include "index.html.php";