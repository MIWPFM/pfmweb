<?php
namespace MIW\DataAccessBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="MIW\DataAccessBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /** @MongoDB\ReferenceOne(targetDocument="User")*/
    private $user;
    
    /** @MongoDB\ReferenceOne(targetDocument="Game")*/
    private $game;
    
    /** 
     * @MongoDB\Date 
     */
    private $created;
    /**
     * @MongoDB\String
     */
    protected $comment;
    
    function __construct() {
        $this->created= new \DateTime();
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
     * Set user
     *
     * @param MIW\DataAccessBundle\Document\User $user
     * @return self
     */
    public function setUser(\MIW\DataAccessBundle\Document\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return MIW\DataAccessBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set game
     *
     * @param MIW\DataAccessBundle\Document\Game $game
     * @return self
     */
    public function setGame(\MIW\DataAccessBundle\Document\Game $game)
    {
        $this->game = $game;
        return $this;
    }

    /**
     * Get game
     *
     * @return MIW\DataAccessBundle\Document\Game $game
     */
    public function getGame()
    {
        return $this->game;
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

    /**
     * Set comment
     *
     * @param string $comment
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Get comment
     *
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }
}
