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

}