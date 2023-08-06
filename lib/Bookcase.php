<?php


namespace elibrary;


class Bookcase
{
    private $bookcaseId;
    private $bookcaseName;
    private $bookcaseCode;
    private $bookcaseRoom;
    private $numberOfShelves;
    private $datasource;

    /**
     * Bookcase constructor.
     * @param $bookcaseId
     * @param $bookcaseName
     * @param $bookcaseCode
     * @param $bookcaseRoom
     * @param $numberOfShelves
     * @param $datasource
     */
    public function __construct($bookcaseId, $bookcaseName, $bookcaseCode, $bookcaseRoom, $numberOfShelves, $datasource)
    {
        $this->bookcaseId = $bookcaseId;
        $this->bookcaseName = $bookcaseName;
        $this->bookcaseCode = $bookcaseCode;
        $this->bookcaseRoom = $bookcaseRoom;
        $this->numberOfShelves = $numberOfShelves;
        $this->datasource = $datasource;
    }

    /**
     * @return mixed
     */
    public function getBookcaseId()
    {
        return $this->bookcaseId;
    }

    /**
     * @param mixed $bookcaseId
     */
    public function setBookcaseId($bookcaseId)
    {
        $this->bookcaseId = $bookcaseId;
    }

    /**
     * @return mixed
     */
    public function getBookcaseName()
    {
        return $this->bookcaseName;
    }

    /**
     * @param mixed $bookcaseName
     */
    public function setBookcaseName($bookcaseName)
    {
        $this->bookcaseName = $bookcaseName;
    }

    /**
     * @return mixed
     */
    public function getBookcaseCode()
    {
        return $this->bookcaseCode;
    }

    /**
     * @param mixed $bookcaseCode
     */
    public function setBookcaseCode($bookcaseCode)
    {
        $this->bookcaseCode = $bookcaseCode;
    }

    /**
     * @return mixed
     */
    public function getBookcaseRoom()
    {
        return $this->bookcaseRoom;
    }

    /**
     * @param mixed $bookcaseRoom
     */
    public function setBookcaseRoom($bookcaseRoom)
    {
        $this->bookcaseRoom = $bookcaseRoom;
    }

    /**
     * @return mixed
     */
    public function getNumberOfShelves()
    {
        return $this->numberOfShelves;
    }

    /**
     * @param mixed $numberOfShelves
     */
    public function setNumberOfShelves($numberOfShelves)
    {
        $this->numberOfShelves = $numberOfShelves;
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
        $sql = "INSERT INTO rb_bookcases (room, description, code, shelves) VALUES ({$this->bookcaseRoom->getRoomId()}, '{$this->bookcaseName}', '{$this->bookcaseCode}', {$this->numberOfShelves})";
        $this->bookcaseId = $this->datasource->executeUpdate($sql);
        $this->bookcaseRoom->updateBookcaseData("add");
    }

    public function update() {
        //$sql = "UPDATE rb_rooms SET name = '{$this->roomName}', code = '{$this->roomCode}', vid = {$this->venue->getId()} WHERE rid = {$this->roomId})";
        //$this->datasource->executeUpdate($sql);
    }

    public function delete($recursive = false) {
        $sql = "DELETE FROM rb_bookcases WHERE bid = {$this->bookcaseId}";
        $this->datasource->executeUpdate($sql);
        $this->bookcaseRoom->updateBookcaseData("del");
        if($recursive) {
            /**
             * implementare la cancellazione ricorsiva di armadi e libri
             */
        }
    }

}