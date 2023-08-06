<?php
/**
 * Created by VS Code
 * User: riccardo
 * Date: 03/08/23
 * Time: 18:28
 */

namespace elibrary;

require_once "Archive.php";

class Venue 
{
    private $venueId;
    private $venueName;
    private $venueCode;
    private $datasource;
    private $venueRooms;
    private $progRooms;

    public function __construct($id, $name, $code, $datasource) {
        $this->venueId = $id;
        $this->venueName = $name;
        $this->venueCode = $code;
        $this->datasource = $datasource;
        $this->venueRooms = [];
        $this->progRooms = 0;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->venueId;
    }

    /**
     * @param mixed $id
     * @return Venue
     */
    public function setId($id)
    {
        $this->venueId = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProgRooms()
    {
        return $this->progRooms;
    }

    /**
     * @param mixed $prog
     */
    public function setProgRooms($prog)
    {
        $this->progRooms = $prog;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->venueName;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->venueName = $name;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->venueCode;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->venueCode = $code;
    }

    /**
     * @return array
     */
    public function getRooms()
    {
        return $this->venueRooms;
    }

    /**
     * @param array $rooms
     * @return Venue
     */
    public function setRooms($rooms)
    {
        $this->venueRooms = $rooms;
        return $this;
    }

    public function addRoom($room) {
        array_push($this->venueRooms, $room);
    }

    public function deleteRoom($room) {

    }

    public function getRooomsNumber() {
        return count($this->venueRooms);
    }

    public function insert() {
        $sql = "INSERT INTO rb_venues (name, code) VALUES ('{$this->venueName}', '{$this->venueCode}')";
        $this->venueId = $this->datasource->executeUpdate($sql);
    }

    public function update() {
        $sql = "UPDATE rb_venues SET name = '{$this->venueName}', code = '{$this->venueCode}'} WHERE vid = {$this->venueId})";
        $this->datasource->executeUpdate($sql);
    }

    public function delete($recursive = false) {
        $sql = "DELETE FROM rb_venues WHERE vid =  {$this->venueId}";
        $this->datasource->executeUpdate($sql);
        if($recursive) {
            /**
             * implementare la cancellazione ricorsiva di stanze, armadi e libri
             */
        }
    }

     /**
     * @param id $room
     * @return string
     */
    public function getRoomCode($rid) {
        $code = null;
        if ($rid == 0){
            $code = $this->createRoomCode();
        }
        return $code;
    }

    public function createRoomCode() {
        //echo "prog==>".$this->progRooms."\n";
        $progressive = nmb_format(($this->getProgRooms() + 1), 2, "0");
        $code = $this->venueCode."-R".$progressive;
        return $code;
    }

    public function loadFields() {
        $sql = "SELECT * FROM rb_venues WHERE vid = ".$this->venueId;
        $values = $this->datasource->executeQuery($sql);
        $this->venueName = $values['name'];
        $this->venueCode = $values['code'];
        $this->progRooms = $values['progressive'];
        
        for($i = 0; $i < $values['rooms']; $i++){
            $this->addRoom(new Room(null, null, null, $this, null));
        }
    }

    public function loadRooms() {

    }


}