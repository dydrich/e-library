<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 27/11/18
 * Time: 20.19
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$drawer_label = "Caricamento utenti";

require_once "insert_users.html.php";