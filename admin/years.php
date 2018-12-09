<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 20/10/17
 * Time: 23.54
 */
require_once "../lib/start.php";

check_session();
$user->setCurrentRole(User::$ADMIN);
check_role($user, User::$ADMIN);

$_SESSION['area'] = 'admin';

$sel_years = "SELECT * FROM rb_years ORDER BY `_id` DESC";
$res_years = $db->executeQuery($sel_years);

$drawer_label = "Anni scolastici";

include "years.html.php";