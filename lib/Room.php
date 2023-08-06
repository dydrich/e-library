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
        $this->bookcases = [];
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

    public function addBookcase($bookcase) {
        array_push($this->bookcases, $bookcase);
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
        $sql = "INSERT INTO rb_rooms (vid, name, code) VALUES ({$this->venue}, '{$this->roomName}', '{$this->roomCode}')";
        $this->roomId = $this->datasource->executeUpdate($sql);
        $archive = Archive::getInstance($this->datasource);
        $archive->update(Archive::$INSERT_ROOM, $this);
    }

    public function update() {
        $sql = "UPDATE rb_rooms SET name = '{$this->roomName}' WHERE rid = {$this->roomId})";
        $this->datasource->executeUpdate($sql);
    }

    public function delete($recursive = false) {
        $sql = "DELETE FROM rb_rooms WHERE rid = {$this->roomId}";
        $this->datasource->executeUpdate($sql);
        $archive = Archive::getInstance($this->datasource);
        $archive->update(Archive::$DELETE_ROOM, $this);
        if($recursive) {
            /**
             * implementare la cancellazione ricorsiva di armadi e libri
             */
        }
    }

    public function loadFields() {
        $sql = "SELECT * FROM rb_rooms WHERE rid = ".$this->roomId;
        $values = $this->datasource->executeQuery($sql);
        $this->roomName = $values['name'];
        $this->roomCode = $values['code'];
        for($i = 0; $i < $values['bookcases']; $i++){
            $this->addBookcase(new Bookcase(null, null, null, null, null, null));
        }
        $this->venue = new Venue($values['vid'], null, null, $this->datasource);
        $this->venue->loadFields();
    }

    public function getBookcaseCode($bookcaseId) {
        $code = null;
        if ($bookcaseId == 0){
            $code = $this->createBookcaseCode();
        }
        return $code;
    }

    protected function createBookcaseCode() {
        $prog = $this->datasource->executeCount("SELECT COALESCE(MAX(bid), 0) FROM `rb_bookcases`");
        $progressive = nmb_format(($prog + 1), 2, "0");
        $code = $this->roomCode."-A".$progressive;
        return $code;
    }

    public function updateBookcaseData($operation) {
        $bookcases = count($this->bookcases);
        if($operation == "add") {
            $this->addBookcase(new Bookcase(null, null, null, null, null, null));
            $bookcases++;
        }
        else {
            array_shift($this->bookcases);
            $bookcases = count($this->bookcases);
            $bookcases--;
        }
        
        $upd = "UPDATE rb_rooms SET bookcases = {$bookcases} WHERE rid = {$this->roomId}";
        $this->datasource->executeUpdate($upd);
    }


}