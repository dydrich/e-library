<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 18/10/17
 * Time: 17.48
 */
require_once "../lib/start.php";

check_session();

$sel_env = "SELECT * FROM rb_settings";
$res_env = $db->executeQuery($sel_env);

$drawer_label = "Variabili d'ambiente";

include_once "settings.html.php";