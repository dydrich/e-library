<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 19/10/17
 * Time: 6.48
 */

require_once "lib/start.php";
//require_once "lib/load_env.php";
require_once "lib/Mobile_Detect.php";

ini_set('display_errors', 1);

$drawer_label = "Home";
$detect = new Mobile_Detect;

include "index-html.php";