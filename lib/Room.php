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
     * @param $venue
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




}