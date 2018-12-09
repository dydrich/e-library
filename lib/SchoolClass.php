<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 25/11/18
 * Time: 18.35
 */

class SchoolClass
{
	private $classID;
	private $grade;
	private $section;
	private $firstYear;
	private $active;

	private $datasource;

	public static $FIRST_UPPER = 1;
	public static $FIRST_LOWER = 2;
	public static $NO_INTRO = 3;

	/**
	 * SchoolClass constructor.
	 * @param $classID
	 * @param $grade
	 * @param $section
	 * @param $firstYear
	 * @param $active
	 * @param $datasource
	 */
	public function __construct($classID, $grade, $section, MySQLDataLoader $datasource, $firstYear = null, $active = null) {
		$this->classID = $classID;
		$this->grade = $grade;
		$this->section = $section;
		$this->firstYear = $firstYear;
		$this->active = $active;
		$this->datasource = $datasource;
	}

	/**
	 * @return mixed
	 */
	public function getClassID() {
		return $this->classID;
	}

	/**
	 * @param mixed $classID
	 */
	private function setClassID($classID) {
		$this->classID = $classID;
	}

	/**
	 * @return mixed
	 */
	public function getGrade() {
		return $this->grade;
	}

	/**
	 * @param mixed $grade
	 */
	public function setGrade($grade) {
		$this->grade = $grade;
	}

	/**
	 * @return mixed
	 */
	public function getSection() {
		return $this->section;
	}

	/**
	 * @param mixed $section
	 */
	public function setSection($section) {
		$this->section = $section;
	}

	/**
	 * @return null
	 */
	public function getFirstYear() {
		return $this->firstYear;
	}

	/**
	 * @param null $firstYear
	 */
	public function setFirstYear($firstYear) {
		$this->firstYear = $firstYear;
	}

	/**
	 * @return null
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * @param null $active
	 */
	public function setActive($active) {
		$this->active = $active;
	}

	/**
	 * @return mixed
	 */
	public function getDatasource() {
		return $this->datasource;
	}

	/**
	 * @param mixed $datasource
	 */
	public function setDatasource($datasource) {
		$this->datasource = $datasource;
	}

	public function insert() {
		$this->classID = $this->datasource->executeUpdate("INSERT INTO rb_classes (year, section, start, active) VALUES({$this->grade}, '{$this->section}', $this->firstYear, 1)");
	}

	public function update() {
		$this->datasource->executeUpdate("UPDATE rb_classes SET year = {$this->grade}, section = '{$this->section}', start = {$this->firstYear} WHERE cid = {$this->classID}");
	}

	public function deactivate() {
		$this->datasource->executeUpdate("UPDATE rb_classes SET active = 0 WHERE cid = {$this->classID}");
		$this->datasource->executeUpdate("UPDATE rb_users SET active = 0 WHERE class = {$this->classID}");
	}

	public function restore() {
		$this->datasource->executeUpdate("UPDATE rb_classes SET active = 1 WHERE cid = {$this->classID}");
		$this->datasource->executeUpdate("UPDATE rb_users SET active = 1 WHERE class = {$this->classID}");
	}

	public function delete() {
		$this->datasource->executeUpdate("DELETE FROM rb_classes WHERE cid = {$this->classID}");
		$this->datasource->executeUpdate("DELETE FROM rb_users WHERE class = {$this->classID}");
	}

	public function toString($style) {
		$intro = '';
		if ($style == self::$FIRST_LOWER) {
			$intro = 'classe ';
		}
		else if ($style == self::$FIRST_UPPER) {
			$intro = 'Classe ';
		}
		return $intro.$this->grade.$this->section;
	}
}