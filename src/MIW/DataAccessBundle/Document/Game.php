<?php

namespace MIW\DataAccessBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as JMS;

/**
 * @MongoDB\Document(repositoryClass="MIW\DataAccessBundle\Repository\GameRepository")
 * @MongoDB\Index(keys={"cordenadas"="2d"})
 */
class Game {
    
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
     * @MongoDB\Date 
     */
    private $gameDate;

    /**
     * @MongoDB\Date 
     */
    private $limitDate;

    /**
     * @MongoDB\Date 
     */
    private $created;

    /**
     * @MongoDB\Int 
     */
    protected $numPlayers;

    /**
     * @MongoDB\Float 
     */
    protected $price;

    /** @MongoDB\ReferenceOne(targetDocument="Center") */
    public $center;

    /** @MongoDB\ReferenceOne(targetDocument="User") */
    private $admin;

    /** @MongoDB\ReferenceOne(targetDocument="Sport") */
    private $sport;

    /** @MongoDB\ReferenceMany(targetDocument="User") */
    private $players;

    public function __construct() {

        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created = new \DateTime();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Set gameDate
     *
     * @param date $gameDate
     * @return self
     */
    public function setGameDate($gameDate) {
        $this->gameDate = $gameDate;
        return $this;
    }

    /**
     * Get gameDate
     *
     * @return date $gameDate
     */
    public function getGameDate() {
        return $this->gameDate;
    }

    /**
     * Set limitDate
     *
     * @param date $limitDate
     * @return self
     */
    public function setLimitDate($limitDate) {
        $this->limitDate = $limitDate;
        return $this;
    }

    /**
     * Get limitDate
     *
     * @return date $limitDate
     */
    public function getLimitDate() {
        return $this->limitDate;
    }

    /**
     * Set created
     *
     * @param date $created
     * @return self
     */
    public function setCreated($created) {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return date $created
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set numPlayers
     *
     * @param int $numPlayers
     * @return self
     */
    public function setNumPlayers($numPlayers) {
        $this->numPlayers = $numPlayers;
        return $this;
    }

    /**
     * Get numPlayers
     *
     * @return int $numPlayers
     */
    public function getNumPlayers() {
        return $this->numPlayers;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return self
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return float $price
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set center
     *
     * @param MIW\DataAccessBundle\Document\Center $center
     * @return self
     */
    public function setCenter(\MIW\DataAccessBundle\Document\Center $center) {
        $this->center = $center;
        return $this;
    }

    /**
     * Get center
     *
     * @return MIW\DataAccessBundle\Document\Center $center
     */
    public function getCenter() {
        return $this->center;
    }

    /**
     * Set admin
     *
     * @param MIW\DataAccessBundle\Document\User $admin
     * @return self
     */
    public function setAdmin(\MIW\DataAccessBundle\Document\User $admin) {
        $this->admin = $admin;
        return $this;
    }

    /**
     * Get admin
     *
     * @return MIW\DataAccessBundle\Document\User $admin
     */
    public function getAdmin() {
        return $this->admin;
    }

    /**
     * Set sport
     *
     * @param MIW\DataAccessBundle\Document\Sport $sport
     * @return self
     */
    public function setSport(\MIW\DataAccessBundle\Document\Sport $sport) {
        $this->sport = $sport;
        return $this;
    }

    /**
     * Get sport
     *
     * @return MIW\DataAccessBundle\Document\Sport $sport
     */
    public function getSport() {
        return $this->sport;
    }

    /**
     * Add player
     *
     * @param MIW\DataAccessBundle\Document\User $player
     */
    public function addPlayer(\MIW\DataAccessBundle\Document\User $player) {
        //$this->players[] = $player;
        $this->players->add($player);
    }

    /**
     * Remove player
     *
     * @param MIW\DataAccessBundle\Document\User $player
     */
    public function removePlayer(\MIW\DataAccessBundle\Document\User $player) {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return Doctrine\Common\Collections\Collection $players
     */
    public function getPlayers() {
        return $this->players;
    }
    
    public function isFull(){
        return (count($this->players)+1 == $this->numPlayers);
    }

}
