<?php

namespace MIW\DataAccessBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\Index(keys={"cordenadas"="2d"})
 */
class Event
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

    /** @MongoDB\EmbedOne(targetDocument="Geolocation") */
    public $geolocation;
    
     /** @MongoDB\Distance */
    public $distance;
    
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

}
