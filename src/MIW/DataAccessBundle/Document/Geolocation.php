<?php

namespace MIW\DataAccessBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\EmbeddedDocument */
class Geolocation
{ 
  
    /** @MongoDB\Float */
    public $long;

    /** @MongoDB\Float */
    public $lat;

    public function getLong() {
        return $this->long;
    }

    public function getLat() {
        return $this->lat;
    }

    public function setLong($long) {
        $this->long = $long;
    }

    public function setLat($lat) {
        $this->lat = $lat;
    }

    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
}
