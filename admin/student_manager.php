<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 23/12/18
 * Time: 10.18
 */
require_once "../lib/start.php";
require_once "../lib/SchoolClass.php";

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
		/*
	    * generate a random id
		*/
		$uniqid = md5(uniqid(rand(), true));
		$tm = new DateTime();
		$now = $tm->format("Y-m-d H:i:s");
		$due = $tm->add(new DateInterval('P1D'));
		
		$smt = $db->prepare("INSERT INTO rb_requests (uid, token, request_date, due_date) VALUES (?, ?, ?, ?)");
		$dt = $due->format("Y-m-d H:i:s");
		$smt->bind_param("isss", $student, $uniqid, $now, $dt);
		$smt->execute();

		/*
		get user email
		*/
		$email = $db->executeCount("SELECT username FROM rb_users WHERE uid = {$student}");

		/*
		* send email
		*/
		//$mail = $_POST['uname'];
		$to = $email;
		$subject = "Richiesta di attivazione";
		$from = "admin@icnivolaiglesias.edu.it";
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: {$from}\r\n"."Reply-To: {$from}\r\n" .'X-Mailer: PHP/' . phpversion();
		$message = "<p>Gentile utente,<br/>abbiamo ricevuto la sua richiesta di attivazione dell'account per l'accesso al servizio di Bibioteca.</p> ";
		$message .= "<p>Se vuoi confermare la richiesta, clicca sul link seguente entro 24 ore:</p>";
		$message .= "<a href='".$_SESSION['__config__']['root_site']."/admin/student_manager.php?action=confirm&token=".$uniqid."'>Conferma la richiesta</a>";
		$message .= "<p>Non rispondere a questa mail, in quanto inviata da un programma automatico.</p>";
		mail($to, $subject, $message, $headers);
		break;
}

$response['message'] = "La tua richiesta è stata ricevuta. Ti abbiamo inviato una mail all'indirizzo istituzionale: clicca sul link contenuto nella mail entro 24 ore per attivare il tuo account";
echo json_encode($response);
exit;