<?php

require_once "../lib/start.php";
require_once "../lib/AccountManager.php";

check_session();

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

$f = $_POST['file'];
$rows = file("../upload/{$f}");
$ok = $ko = $tot = 0;
$tot = count($rows);
$errs = "";
/* log */
$log_path = "accounts".date("YmdHis").".txt";
$log = fopen("../upload/{$log_path}", "w");
foreach($rows as $row){
	list($cognome, $nome, $cod_classe, $email) = explode(",", $row);
	$sel_id = "SELECT cid FROM rb_classes WHERE year = ".substr($cod_classe, 0, 1)." AND section = '".substr($cod_classe, 1, 1)."'";
	$id_classe = $db->executeCount($sel_id);

	$cognome = $db->real_escape_string($cognome);
	$nome = $db->real_escape_string($nome);
	$email = $db->real_escape_string($email);
	$pwd = AccountManager::generatePassword();

	$insert = "INSERT INTO rb_users (username, password, lastname, firstname, registration_date, class, active, email) 
			  VALUES ('$email', '{$pwd['e']}', '$cognome', '$nome', NOW(), $id_classe, 0, '$email')";
	try{
		$uid = $db->executeUpdate($insert);
		$db->executeUpdate("INSERT INTO rb_user_roles (uid, rid) VALUES ({$uid}, 3)");
		fwrite($log, "{$cognome} {$nome} (".substr($cod_classe, 0, 2)."): {$username}:{$pwd_chiaro}\n");
		$ok++;
	} catch (MySQLException $ex) {
		$ko++;
		fwrite($log, "Failure: ".$ex->getQuery()." --- ".$ex->getMessage()."\n");
		$response['status'] = "kosql";
		$response['message'] = "Operazione non completata a causa di un errore";
		$response['dbg_message'] = $ex->getMessage();
		$response['query'] = $ex->getQuery();
	}
}
fclose($log);
unlink("../upload/".$f);

$response['ok'] = $ok;
$response['tot'] = $tot;
$response['ko'] = $ko;
$response['log_path'] = $log_path;

echo json_encode($response);
exit;
