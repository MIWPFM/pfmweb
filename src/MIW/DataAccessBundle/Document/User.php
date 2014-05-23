<?php
namespace MIW\DataAccessBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @MongoDB\Document
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;
    
    /**
     * @MongoDB\String
     */
    protected $name;
    
    /**
     * @MongoDB\String
     */
    protected $hash;
    
    /** 
     * @MongoDB\Date 
     */
    private $created;
    
    /** 
     * @MongoDB\Date 
     */
    private $birthday;
    
    /** @MongoDB\EmbedOne(targetDocument="Address") 
    *     @MaxDepth(1)
     *      */
    private $address;
    
    /** @MongoDB\Hash  */
    private $sports;

    /** @MongoDB\Boolean */
    private $completedProfile;

    public function __construct()
    {
        parent::__construct();
        $this->created=new \DateTime();
        $this->completedProfile=false;

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
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set hash
     *
     * @param string $hash
     * @return self
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * Get hash
     *
     * @return string $hash
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set created
     *
     * @param date $created
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return date $created
     */
    public function getCreated()
    {
        return $this->created;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    
    /**
     * Set birthday
     *
     * @param date $birthday
     * @return self
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * Get birthday
     *
     * @return date $birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set sports
     *
     * @param hash $sports
     * @return self
     */
    public function setSports($sports)
    {
        $this->sports = $sports;
        return $this;
    }

    /**
     * Get sports
     *
     * @return hash $sports
     */
    public function getSports()
    {
        return $this->sports;
    }
    
    /**
     * Add sport
     *
     */
    public function addSport($key, $sport)
    {
        $this->sports[$key] = $sport;
    }
    
    /**
     * Remove sport
     *
     */
    public function removeSport($key)
    {
        unset($this->sports[$key]);
    }
    
    public function getCompletedProfile() {
        return $this->completedProfile;
    }

    public function setCompletedProfile($completedProfile) {
        $this->completedProfile = $completedProfile;
    }


}
