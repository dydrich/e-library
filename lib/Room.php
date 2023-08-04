<?php


namespace elibrary;


class Room
{
    private $roomId;
    private $roomName;
    private $roomCode;
    private $bookcases;
    private $venue;
    private $datasource;

    /**
     * Room constructor.
     * @param $roomId
     * @param $roomName
     * @param $roomCode
     * @param \elibrary\Venue $venue
     * @param $datasource
     */
    public function __construct($roomId, $roomName, $roomCode, $venue, $datasource)
    {
        $this->roomId = $roomId;
        $this->roomName = $roomName;
        $this->roomCode = $roomCode;
        $this->venue = $venue;
        $this->datasource = $datasource;
    }

    /**
     * @return mixed
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param mixed $roomId
     */
    public function setRoomId($roomId)
    {
        $this->roomId = $roomId;
    }

    /**
     * @return mixed
     */
    public function getRoomName()
    {
        return $this->roomName;
    }

    /**
     * @param mixed $roomName
     */
    public function setRoomName($roomName)
    {
        $this->roomName = $roomName;
    }

    /**
     * @return mixed
     */
    public function getRoomCode()
    {
        return $this->roomCode;
    }

    /**
     * @param mixed $roomCode
     */
    public function setRoomCode($roomCode)
    {
        $this->roomCode = $roomCode;
    }

    /**
     * @return mixed
     */
    public function getBookcases()
    {
        return $this->bookcases;
    }

    /**
     * @param mixed $bookcases
     */
    public function setBookcases($bookcases)
    {
        $this->bookcases = $bookcases;
    }

    /**
     * @return mixed
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param mixed $venue
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    /**
     * @return mixed
     */
    public function getDatasource()
    {
        return $this->datasource;
    }

    /**
     * @param mixed $datasource
     */
    public function setDatasource($datasource)
    {
        $this->datasource = $datasource;
    }

    public function insert() {
        $sql = "INSERT INTO rb_rooms (vid, name, code) VALUES ({$this->venue->getId()}, '{$this->roomName}', '{$this->roomCode}')";
        $this->roomId = $this->datasource->executeUpdate($sql);
    }

    public function update() {
        $sql = "UPDATE rb_rooms SET name = '{$this->roomName}', code = '{$this->roomCode}', vid = {$this->venue->getId()} WHERE rid = {$this->roomId})";
        $this->datasource->executeUpdate($sql);
    }

    public function delete($recursive = false) {
        $sql = "DELETE FROM rb_rooms WHERE rid =  {$this->roomId}";
        $this->datasource->executeUpdate($sql);
        if($recursive) {
            /**
             * implementare la cancellazione ricorsiva di stanze, armadi e libri
             */
        }
    }


}