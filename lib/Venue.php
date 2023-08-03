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
    private $id;
    private $name;
    private $code;

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
     * @return Venue
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
     * @return Venue
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }


}