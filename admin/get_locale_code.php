<?php

require_once "../lib/start.php";
require_once "../lib/Venue.php";
require_once "../lib/Room.php";
require_once "../lib/Bookcase.php";

ini_set('display_errors', 1);

check_session(AJAX_CALL);

$value = $_REQUEST['object_id'];
$object_type = $_REQUEST['type'];
$act = $_REQUEST['object_action'];
$code = null;
switch ($object_type) {
    case "room":
        $venue = new \elibrary\Venue($value, null, null, new MySQLDataLoader($db));
        $venue->loadFields();
        $code = $venue->getRoomCode($act);
        break;
    case "bookcase":
        $room = new \elibrary\Room($value, null, null, null, new MySQLDataLoader($db));
        $room->loadFields();
        $code = $room->getBookcaseCode($act);
    default:
        break;
}


$response['code'] = $code;
echo json_encode($response);
exit;