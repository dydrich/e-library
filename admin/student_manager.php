<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 23/12/18
 * Time: 10.18
 */
require_once "../lib/start.php";
require_once "../lib/SchoolClass.php";
require_once "../lib/RBUtilities.php";
require_once "../lib/AccountManager.php";

//check_session(AJAX_CALL);

$cid = isset($_POST['cid']) ? $_POST['cid'] : 0;
$student = $_REQUEST['student'];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_REQUEST['action']){
	case 'move_student':
		try{
			$begin = $db->executeUpdate("BEGIN");
			if($cid !=  0) {
				$db->executeUpdate("UPDATE rb_users SET class = {$cid} WHERE uid = {$student}");
			}
			else {
				$db->executeUpdate("UPDATE rb_users SET class = NULL WHERE uid = {$student}");
			}
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore SQL";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Operazione eseguita";
		break;
	case 'charge_student':
		$class = new SchoolClass($_POST['cid'], null, null, new MySQLDataLoader($db), null, null);
		try{
			$begin = $db->executeUpdate("BEGIN");
			$class->setPersonInCharge($student);
			$commit = $db->executeUpdate("COMMIT");
		} catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore SQL";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Operazione eseguita";
		break;
	/** aggiunge uno studente, che ne ha fatto richiesta, al servizio
	*	invia una mail all'indirizzo istituzionale dell'alunno per confermare l'identità	
	**/	
	case 'add_student':
		$rb = RBUtilities::getInstance($db);
		
		try{
			$user = $rb->loadUserFromUid($student);
			$am = new AccountManager($user, new MySQLDataLoader($db));
			$am->sendActivationCode();
			$response['message'] = "La tua richiesta è stata ricevuta. Inserisci nello spazio sotto il codice che ti abbiamo inviato all'indirizzo email istituzionale entro 15 minuti";
		} catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore SQL";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		break;
	/** attiva uno studente, che ne ha fatto richiesta
	*		
	**/	
	case 'activate_student':
		$rb = RBUtilities::getInstance($db);
		$code = $_REQUEST['code'];
		//echo "have a code ".$code;
		try{
			$user = $rb->loadUserFromUid($student);
			$am = new AccountManager($user, new MySQLDataLoader($db));
			$out = $am->checkActivationCode($code);
			$response['out'] = $out;
		} catch (MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore SQL";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		
		break;
}

//$response['message'] = "La tua richiesta è stata ricevuta. Ti abbiamo inviato una mail all'indirizzo istituzionale: clicca sul link contenuto nella mail entro 24 ore per attivare il tuo account";
echo json_encode($response);
exit;