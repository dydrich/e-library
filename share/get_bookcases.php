<?php

require_once "../lib/start.php";

check_session(AJAX_CALL);

$room = $_REQUEST['room'];

$sel_bookcases = "SELECT * FROM rb_bookcases WHERE room = $room";
$res_bookcases = $db->executeQuery($sel_bookcases);
$bookcases = [];
while ($row = $res_bookcases->fetch_assoc()) {
	$bookcases[$row['bid']] = $row;
}

$response['bookcases'] = $bookcases;
echo json_encode($response);
exit;
