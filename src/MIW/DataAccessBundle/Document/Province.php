<?php
namespace MIW\DataAccessBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Province
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
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }


}
