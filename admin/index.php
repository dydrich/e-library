<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 09/10/17
 * Time: 21.37
 */
require_once "../lib/start.php";

check_session();
check_role(\edocs\User::$ADMIN);

$_SESSION['area'] = 'admin';

try {
	$users_count = $db->executeCount("SELECT COUNT(*) FROM rb_users WHERE role <> 3");
	$docs_count = $db->executeCount("SELECT COUNT(*) FROM rb_documents");
	// dati traffico
	$monthly_users = $db->executeCount("SELECT COUNT(*) FROM rb_users WHERE registration_date > (NOW() - INTERVAL 1 MONTH)");
	$monthly_docs = $db->executeCount("SELECT COUNT(*) FROM rb_documents WHERE upload_date > (NOW() - INTERVAL 1 MONTH)");
	$monthly_public_accesses = $db->executeCount("SELECT COUNT(*) FROM rb_visits WHERE uri LIKE '%front%' AND access_ts > (NOW() - INTERVAL 1 MONTH)");
	$monthly_private_accesses = $db->executeCount("SELECT COUNT(*) FROM rb_visits WHERE uri = '/edocs/back/index.php' AND access_ts > (NOW() - INTERVAL 1 MONTH)");
} catch (\edocs\MySQLException $ex) {

}

$drawer_label = "Dashboard";

include "index.html.php";