<?php

namespace MIW\DataAccessBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\Index(keys={"cordenadas"="2d"})
 */
class Sport
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
    /** 
     * @MongoDB\Int 
     */
    protected $minPlayers;
    
    /**
     * @MongoDB\String
     */
    private $level;
    
    /** @MongoDB\Hash  */
    private $attributes;
    
    public function getId() {
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
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set minPlayers
     *
     * @param int $minPlayers
     * @return self
     */
    public function setMinPlayers($minPlayers)
    {
        $this->minPlayers = $minPlayers;
        return $this;
    }

    /**
     * Get minPlayers
     *
     * @return int $minPlayers
     */
    public function getMinPlayers()
    {
        return $this->minPlayers;
    }
    
    /**
     * Set level
     *
     * @param string $level
     * @return self
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * Get level
     *
     * @return string $level
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * Set attributes
     *
     * @param hash $attributes
     * @return self
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get attributes
     *
     * @return hash $attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
