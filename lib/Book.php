<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 26/12/18
 * Time: 10.12
 */

namespace elibrary;


class Book
{
	private $bookID;
	private $title;
	private $author;
	private $publisher;
	private $fistEditionYear;
	private $bookEditionYear;
	private $pages;
	private $avalaible;
	private $loanData = ['id' => null, 'studentID' => null, 'date' => null];
	private $location = ['school_complex' => null, 'room' => null, 'bookcase' => null, 'shelf' => null];
	private $reviews;
	private $history = [['id' => null, 'studentID' => null, 'loan_date' => null, 'return_date' => null]];
	private $datasource;
	private $code;

	/**
	 * Book constructor.
	 * @param $bookID
	 * @param $title
	 * @param $author
	 * @param $publisher
	 * @param $fistEditionYear
	 * @param $bookEditionYear
	 * @param $pages
	 * @param $isBorrowed
	 * @param array $borrowData
	 * @param array $location
	 * @param $reviews
	 * @param array $history
	 * @param $datasource
	 * @param $code
	 */
	public function __construct($bookID, $title, $author, $publisher, $fistEditionYear, $bookEditionYear, $pages, array $location, $datasource, $code) {
		$this->bookID = $bookID;
		$this->title = $title;
		$this->author = $author;
		$this->publisher = $publisher;
		$this->fistEditionYear = $fistEditionYear;
		$this->bookEditionYear = $bookEditionYear;
		$this->pages = $pages;
		$this->location = $location;
		$this->datasource = $datasource;
		$this->code = $code;
	}

	/**
	 * @return mixed
	 */
	public function getBookID() {
		return $this->bookID;
	}

	/**
	 * @param mixed $bookID
	 */
	public function setBookID($bookID) {
		$this->bookID = $bookID;
	}

	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * @param mixed $author
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * @return mixed
	 */
	public function getPublisher() {
		return $this->publisher;
	}

	/**
	 * @param mixed $publisher
	 */
	public function setPublisher($publisher) {
		$this->publisher = $publisher;
	}

	/**
	 * @return mixed
	 */
	public function getFistEditionYear() {
		return $this->fistEditionYear;
	}

	/**
	 * @param mixed $fistEditionYear
	 */
	public function setFistEditionYear($fistEditionYear) {
		$this->fistEditionYear = $fistEditionYear;
	}

	/**
	 * @return mixed
	 */
	public function getBookEditionYear() {
		return $this->bookEditionYear;
	}

	/**
	 * @param mixed $bookEditionYear
	 */
	public function setBookEditionYear($bookEditionYear) {
		$this->bookEditionYear = $bookEditionYear;
	}

	/**
	 * @return mixed
	 */
	public function getPages() {
		return $this->pages;
	}

	/**
	 * @param mixed $pages
	 */
	public function setPages($pages) {
		$this->pages = $pages;
	}

	/**
	 * @return mixed
	 */
	public function isAvalaible() {
		return $this->avalaible;
	}

	/**
	 * @param mixed $avalaible
	 */
	public function setAvalaible($avalaible) {
		$this->avalaible = $avalaible;
	}

	/**
	 * @return array
	 */
	public function getLoanData() {
		return $this->loanData;
	}

	/**
	 * @param array $loanData
	 */
	public function setLoanData($loanData) {
		$this->loanData = $loanData;
	}

	/**
	 * @return array
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * @param array $location
	 */
	public function setLocation($location) {
		$this->location = $location;
	}

	/**
	 * @return mixed
	 */
	public function getReviews() {
		return $this->reviews;
	}

	/**
	 * @param mixed $reviews
	 */
	public function setReviews($reviews) {
		$this->reviews = $reviews;
	}

	/**
	 * @return array
	 */
	public function getHistory() {
		return $this->history;
	}

	/**
	 * @param array $history
	 */
	public function setHistory($history) {
		$this->history = $history;
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
	public function setDatasource(\MySQLDataLoader $datasource) {
		$this->datasource = $datasource;
	}
	
	public function insert() {
		$sql = "INSERT INTO rb_books (author, title, publisher, school_complex, room, bookcase, shelf)
				VALUES ('{$this->author}', '{$this->title}', '{$this->publisher}', {$this->location['school_complex']}, {$this->location['room']}, {$this->location['bookcase']}, {$this->location['shelf']}) ";
		$this->bookID = $this->datasource->executeUpdate($sql);
	}
	
	public function update() {
		$sql = "UPDATE rb_books SET author = '{$this->author}', title = '{$this->title}', publisher = '{$this->publisher}', school_complex = {$this->location['school_complex']},
				room = {$this->location['room']}, shelf = {$this->location['shelf']}
				WHERE bid = {$this->bookID}";
		$this->datasource->executeUpdate($sql);
	}
	
	public function delete() {
		$sql = "DELETE FROM rb_books WHERE bid = {$this->bookID}";
		$this->datasource->executeUpdate($sql);
	}

}