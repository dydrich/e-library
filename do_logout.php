<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 17/10/17
 * Time: 16.44
 */

include_once 'lib/start.php';
//session_start();
if ($_SESSION){
	session_destroy();
	unset($_SESSION);
}
header("Location: ".ROOT_SITE);
exit;