<?php

namespace MIW\DataAccessBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * CenterRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CenterRepository extends DocumentRepository
{
    public function findAllByNameRegex($name)
    {
        return $this->createQueryBuilder()
            ->field('name')->equals(new \MongoRegex('/.*'.$name.'.*/i'))
            ->getQuery()
            ->execute();
    }
}