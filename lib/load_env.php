<?php

// settings
$sel_config = "SELECT * FROM rb_settings";
$res_config = $db->executeQuery($sel_config);
$config = array();
while($row = $res_config->fetch_assoc()){
	$config[$row['var']] = stripslashes($row['value']);
}
$_SESSION['__config__'] = $config;