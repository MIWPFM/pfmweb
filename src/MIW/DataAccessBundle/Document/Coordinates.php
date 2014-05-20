<?php

namespace MIW\DataAccessBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\EmbeddedDocument 
*/
class Coordinates
{
    /** @MongoDB\Float */
    public $x;

    /** @MongoDB\Float */
    public $y;
    
    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

    public function setX($x) {
        $this->x = $x;
    }

    public function setY($y) {
        $this->y = $y;
    }


}