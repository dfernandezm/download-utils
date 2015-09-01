<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 31/08/2015
 * Time: 22:12
 */
namespace Morenware\DutilsBundle\Entity;

class FileInListing
{
    private $name;
    private $rights;
    private $size;
    private $date;
    private $type;
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
    public function getRights()
    {
        return $this->rights;
    }
    /**
     * @param mixed $rights
     */
    public function setRights($rights)
    {
        $this->rights = $rights;
    }
    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }
    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}