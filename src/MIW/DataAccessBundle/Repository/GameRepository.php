<?php

namespace MIW\DataAccessBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Description of GameRepository
 *
 * 
 */
class GameRepository extends DocumentRepository {
    
    public function findAllByDate($valueDate)
    {
        return $this->createQueryBuilder()
           ->field('gameDate')->equals($valueDate)
           ->getQuery()
           ->execute();
    }  
    
    public function findAllBetweenDates($initDate, $endDate)
    {
        return $this->createQueryBuilder()
            ->field('gameDate')->range($initDate, $endDate)
            ->getQuery()
            ->execute();
    }  
    
}
