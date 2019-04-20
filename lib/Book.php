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
	private $isBorrowed;
	private $borrowData = ['id' => null, 'studentID' => null, 'date' => null];
	private $location = ['school_complex' => null, 'room' => null, 'bookcase' => null, 'shelf' => null];
	private $reviews;
	private $history = [['id' => null, 'studentID' => null, 'loan_date' => null, 'return_date' => null]];
	private $datasource;

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
	 */
	public function __construct($bookID, $title, $author, $publisher, $fistEditionYear, $bookEditionYear, $pages, $isBorrowed, array $borrowData, array $location, $reviews, array $history, $datasource) {
		$this->bookID = $bookID;
		$this->title = $title;
		$this->author = $author;
		$this->publisher = $publisher;
		$this->fistEditionYear = $fistEditionYear;
		$this->bookEditionYear = $bookEditionYear;
		$this->pages = $pages;
		$this->isBorrowed = $isBorrowed;
		$this->borrowData = $borrowData;
		$this->location = $location;
		$this->reviews = $reviews;
		$this->history = $history;
		$this->datasource = $datasource;
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
	public function getisBorrowed() {
		return $this->isBorrowed;
	}

	/**
	 * @param mixed $isBorrowed
	 */
	public function setIsBorrowed($isBorrowed) {
		$this->isBorrowed = $isBorrowed;
	}

	/**
	 * @return array
	 */
	public function getBorrowData() {
		return $this->borrowData;
	}

	/**
	 * @param array $borrowData
	 */
	public function setBorrowData($borrowData) {
		$this->borrowData = $borrowData;
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

}