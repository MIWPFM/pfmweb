<?php

namespace MIW\DataAccessBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Center
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\String
     */
    protected $description;

    /** @MongoDB\EmbedOne(targetDocument="Address") */
    public $address;
    
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDistance() {
        return $this->distance;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDistance($distance) {
        $this->distance = $distance;
    }


    /**
     * Set address
     *
     * @param MIW\DataAccessBundle\Document\Address $address
     * @return self
     */
    public function setAddress(\MIW\DataAccessBundle\Document\Address $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return MIW\DataAccessBundle\Document\Address $address
     */
    public function getAddress()
    {
        return $this->address;
    }
}
