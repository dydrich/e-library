<?php

require_once "../lib/start.php";

$response = array("status" => "ok");
header("Content-type: application/json");

if ($_POST['action'] == ACTION_DELETE) {
	// quick delete
	$f = $_POST['file'];
	if (file_exists("../upload/".$f)){
		unlink("../upload/".$f);
	}
	$response['message'] = "Il file è stato cancellato";
	$res = json_encode($response);
	echo $res;
	exit;
}

$res = json_encode($response);
echo $res;
exit;
