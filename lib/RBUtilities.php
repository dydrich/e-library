<?php

require_once "data_source.php";
require_once "Authenticator.php";

final class RBUtilities{
	
	private $datasource;
	private static $instance;
	
	private function __construct($conn){
		if ($conn instanceof MySQLDataLoader){
			$this->datasource = $conn;
		}
		else{
			$this->datasource = new MySQLDataLoader($conn);
		}
	}

	/**
	 * Load an instance of RBUtilities - Singleton
	 * @param MySQLConnection or MySQLDataLoader $conn - db access
	 * @return RBUtilities instance
	 */
	public static function getInstance($conn){
		if(empty(self::$instance)){
			self::$instance = new RBUtilities($conn);
		}
		return self::$instance;
	}

	/**
	 * Load an instance of some User class
	 * @param integer $uid - the user's id
	 * @return \edocs\User $user
	 */
	public function loadUserFromUid($uid){
			$sel_user = "SELECT firstname, lastname, username, accesses_count, role, active FROM rb_users WHERE rb_users.uid = {$uid} ";
				$ut = $this->datasource->executeQuery($sel_user);
				$utente = $ut;

				$user = new \edocs\User($uid, $utente['firstname'], $utente['lastname'], $utente['username'], null, $utente['role'], $this->datasource);
				$user->setActive($utente['active']);

		return $user;
	}

	/**
	 * Returns the distance between dates in a human readable style
	 * @param DateTime $start_date
	 * @param DateTime|null $end_date
	 * @return bool|DateInterval
	 */
	public static function getDateTimeDistance(DateTime $start_date, DateTime $end_date = null) {
		if ($end_date == null) {
			$end_date = new DateTime();
		}
		$distance = $end_date->diff($start_date);
		if ($distance->y > 1) {
			return "oltre ".$distance->y." anni fa";
		}
		else if ($distance->y == 1) {
			return "oltre un anno fa";
		}
		else if ($distance->m > 1) {
			return "oltre ".$distance->m." mesi fa";
		}
		else if ($distance->m == 1) {
			return "oltre un mese fa";
		}
		else if ($distance->d > 1) {
			return "oltre ".$distance->d." giorni fa";
		}
		else if ($distance->d == 1) {
			return "oltre un giorno fa";
		}
		else if ($distance->h > 1) {
			return "oltre ".$distance->h." ore fa";
		}
		else if ($distance->h == 1) {
			return "oltre un'ora fa";
		}
		else if ($distance->i > 35) {
			return "meno di un'ora fa";
		}
		else if ($distance->i < 35 && $distance->i > 30) {
			return "circa mezz'ora fa";
		}
		else if ($distance->i > 10) {
			return "meno di mezz'ora fa";
		}
		else if ($distance->i > 1) {
			return "pochi minuti fa";
		}
		else if ($distance->i == 0) {
			return "pochi secondi fa";
		}
		return "";
	}
	
}
