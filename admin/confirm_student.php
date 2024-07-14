<?php
/**
 * Created by VSCode.
 * User: riccardo
 * Date: 08/10/23
 * Time: 11:20
 */

require_once "lib/start.php";
require_once "lib/load_env.php";
require_once "lib/Mobile_Detect.php";

ini_set('display_errors', 1);

$drawer_label = "Conferma la richiesta";
$detect = new Mobile_Detect;

/**
* attiva l'utente a seguito della conferma
* segue il link della mail
*/
$token = $_GET['token'];
$id_valid = true;
$background_color = "white";
$response = array("status" => "ok", "message" => "Operazione completata");
try {
    $res = $db->executeQuery("SELECT * FROM rb_requests WHERE token = '{$token}'");
    $vals = $res->fetch_assoc();
    if(count($vals) = 0) {
        $response['message'] = "Token non valido";
        $response['error_code'] = "TK2";
        $response['status'] = "ko";
        $id_valid = false;
        $background_color = "rgba(200, 6, 6, .2)";
    }
    else if($vals['state'] == "completed") {
        $response['message'] = "Token già utilizzato: il tuo account è già attivo";
        $response['error_code'] = "TK1";
        $response['status'] = "ko";
        $id_valid = false;
        $background_color = "rgba(242, 186, 29, .2)";
    }
    else {
        $tm = new DateTime();
        $now = $tm->format("Y-m-d H:i:s");
        $due_date = $vals['due_date'];
        if($now > $due_date) {
            $response['message'] = "Il token è scaduto: ripeti la procedura e richiedine un altro";
            $response['error_code'] = "TK3";
            $response['status'] = "ko";
            $id_valid = false;
            $background_color = "rgba(200, 6, 6, .2)";
        }
        else {
            $db->executeUpdate("UPDATE rb_requests SET state = 'completed' WHERE _id = {$vals['_id']}");
            $db->executeUpdate("UPDATE rb_users SET active = 1 WHERE uid = '".$vals['uid']."'");
            $response['message'] = "Il tuo account è stato attivato: per completare l'operazione, inserisci una password per l'accesso";            
        }
    }
} catch (MySQLException $ex) {
    $response['status'] = "kosql";
    $response['message'] = "Operazione non completata a causa di un errore SQL nel recupero dati token";
    $response['dbg_message'] = $ex->getMessage();
    $response['query'] = $ex->getQuery();
}
//$_SESSION['response'] = $response;

include "confirm_student.html.php";