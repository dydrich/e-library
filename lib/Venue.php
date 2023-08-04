<?php
/**
 * Created by VS Code
 * User: riccardo
 * Date: 03/08/23
 * Time: 18:28
 */

namespace elibrary;

class Venue 
{
    private $venueId;
    private $venueName;
    private $venueCode;
    private $datasource;
    private $venueRooms;

    public function __construct($id, $name, $code, $datasource) {
        $this->venueId = $id;
        $this->venueName = $name;
        $this->venueCode = $code;
        $this->datasource = $datasource;
        $this->venueRooms = [];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Venue
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return array
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param array $rooms
     * @return Venue
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;
        return $this;
    }

    public function addRoom($room) {
        array_push($this->rooms, $room);
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


}