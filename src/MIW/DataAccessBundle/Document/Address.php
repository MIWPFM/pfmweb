<?php

namespace MIW\DataAccessBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\EmbeddedDocument 
  @MongoDB\Index(keys={"coordinates"="2d"}) */
class Address
{ 
    /**
     * @MongoDB\String
     */
    protected $address;
    
    /**
     * @MongoDB\String
     */
    protected $zipcode;
    
    /**
     * @MongoDB\String
     */
    protected $city;
    
    /**
     * @MongoDB\String
     */
    protected $province;
    
    /**
     * @MongoDB\String
     */
    protected $community;
    
    /** @MongoDB\EmbedOne(targetDocument="Coordinates") */
    public $coordinates;

    /** @MongoDB\Distance */
    public $distance;

    public function getCoordinates() {
        return $this->coordinates;
    }

    public function getDistance() {
        return $this->distance;
    }

    public function setCoordinates($coordinates) {
        $this->coordinates = $coordinates;
    }

    public function setDistance($distance) {
        $this->distance = $distance;
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

    /**
     * Set address
     *
     * @param string $address
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return string $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return self
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * Get address
     *
     * @return string $zipcode
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set province
     *
     * @param string $province
     * @return self
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * Get province
     *
     * @return string $province
     */
    public function getProvince()
    {
        return $this->province;
    }


    public function getCommunity() {
        return $this->community;
    }

    public function setCommunity($community) {
        $this->community = $community;
    }

    public function __toString() {
        return $this->address;
    }


}
