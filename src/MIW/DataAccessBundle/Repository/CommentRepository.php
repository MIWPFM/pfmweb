<?php

namespace MIW\DataAccessBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * CenterRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends DocumentRepository
{
    public function findAllByGame($game)
    {
        return $this->createQueryBuilder()
            ->field('game.id')->equals($game->getId())
            ->sort('created', 'desc')
            ->getQuery()
            ->execute();
    }
}