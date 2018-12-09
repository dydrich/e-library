<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 27/11/18
 * Time: 20.13
 */

require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$drawer_label = "Funzioni utili";

include "utilities.html.php";