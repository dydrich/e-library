<?php

require_once "../lib/start.php";

$field = $_REQUEST['id'];
$value = $_REQUEST['value'];

$upd = "UPDATE rb_settings SET value = '$value' WHERE var = '$field'";
$update_var = $db->executeUpdate($upd);
$_SESSION['__config__'][$field] = $value;

require_once "../lib/load_env.php";

header("Content-type: text/plain");
print $value;
exit;
