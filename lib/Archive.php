<?php
/**
 * Created by VS Code
 * User: riccardo
 * Date: 03/08/23
 * Time: 15:20
 */

namespace elibrary;

class Archive
{

    public static $INSERT_ROOM = 1;
    public static $DELETE_ROOM = 2;
    public static $INSERT_BOOKCASE = 3;
    public static $DELETE_BOOKCASE = 4;

    private $venues;
    private $rooms;
    private $bookcases;
    private static $instance;
	private $datasource;
	
	private function __construct($conn){
		$this->datasource = $conn;
	}

    public static function getInstance($conn){
		if(empty(self::$instance)){
			self::$instance = new Archive($conn);
		}
		return self::$instance;
	}

    public function update($action, $object){
        switch($action){
            case Archive::$INSERT_ROOM:
                $this->updateRooms($object, "add");
                break;
            case Archive::$DELETE_ROOM:
                $this->updateRooms($object, "del");
                break;
            default:
            break;
        }
    }

    protected function updateRooms($room, $operation){
        $vid = $room->getVenue();
        $venue = new Venue($vid, null, null, $this->datasource);
        $venue->loadFields();

        $sel = "SELECT rid FROM rb_rooms WHERE vid = {$venue->getID()}";
        $rids = $this->datasource->executeQuery($sel);
        $rooms = count($rids);
        $prog = $venue->getProgRooms();
        if($operation == "add") {
            $prog++;
        }
        else {
            $prog--;
        }
        
        $upd = "UPDATE rb_venues SET rooms = {$rooms}, progressive = {$prog} WHERE vid = {$venue->getId()}";
        $this->datasource->executeUpdate($upd);
    }

    public function getBookFromId($bookId) {
        $select = "SELECT * FROM rb_books WHERE bid = {$bookId}";
        $res = $this->datasource->executeQuery($select);
        $sel_cat = "SELECT rb_categories.* FROM rb_categories JOIN `rb_categories_book` ON rb_categories.cid = rb_categories_book.cid WHERE bid = {$bookId}";
        $cat = $his->datasource->executeQuery($sel_cat);
        $res['cat'] = $cat;
        $location = ['school_complex' => $res['school_complex'], 'room' => $res['room'], 'bookcase' => $res['bookcase'], 'shelf' => $res['shelf']];
        $book = new Book($bookId, $res['title'], $res['author'], $res['publisher'], $res['cat']['cid'], $res['cover'], $res['pages'], $location, $this->datasource, $res['code']);
        return $book;
    }

    public function getBookCode($bookId, $category) {
        if($bookId == 0) {
            $max = $this->datasource->executeCount("SELECT MAX(bid) FROM rb_books");
            $max++;
            $cat_code = $this->datasource->executeCount("SELECT code FROM rb_categories WHERE cid = {$category}");
            $code = $cat_code."-";
            $prog = nmb_format($max, 6, "0");
            $code .= $prog;
            return $code;
        }
    }

}