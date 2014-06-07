<?php

namespace MIW\DataAccessBundle\DataFixtures\ODM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MIW\DataAccessBundle\Document\Game;


class LoadGames extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function getOrder(){
        return 4;
    }
   /* php app/console doctrine:mongodb:fixtures:load --fixtures src/MIW/DataAccessBundle/DataFixtures/ODM */
    public function load(ObjectManager $manager){
        print_r("Loading Games\n");
        $football= $this->getReference('football');
        $paddel= $this->getReference('paddel');
        $volleyball= $this->getReference('voleyball');
        $basket= $this->getReference('basket');
        $beisbol= $this->getReference('beisbol');
        
        $sports=array($football,$paddel,$volleyball,$basket,$beisbol);
        
        $user= $this->getReference('adrian');
        $user2= $this->getReference('lien');
        $user3= $this->getReference('alberto');
        $user4= $this->getReference('admin');
        
        $users=array($user,$user2,$user3,$user4);
        
        $center= $this->getReference('center');
        $center2= $this->getReference('center2');
        $center3= $this->getReference('center3');
        $center4= $this->getReference('center4');
        $center5= $this->getReference('center5');
                
        $centers=array($center,$center2,$center3,$center4,$center5);
        
        for ($index = 0; $index < 100; $index++) {
            $game=$this->createRandomGame($users,$sports,$centers);
            $manager->persist($game);
            $manager->flush();
        }
 
    }
    
    
    public function createRandomGame($users,$sports,$centers){
        
        $gameDate=$this->getRandomDate();
        $createdDate= clone $gameDate;
        $limitDate= clone $gameDate;
        $game = new Game();
        $game->setAdmin($users[rand(0,3)]);
        $game->setCreated($createdDate->modify("-10 days"));
        $game->setGameDate($gameDate);
        $game->setLimitDate($limitDate->modify("-1 day"));
        $game->setPrice(rand(3,10));
        $game->setNumPlayers(rand(3,10));
        $game->setSport($sports[rand(0,4)]);
        $game->setDescription("Creo este evento en tal sitio por que quiero bla bla");
        $game->setCenter($centers[rand(0,4)]);
        $game->addPlayer($users[rand(0,3)]);
        $game->addPlayer($users[rand(0,3)]);
        
        return $game;
        
    }
    public function getRandomDate()
    {
        $days=rand(1,10);
        $bool=rand(0,1);
        if($bool==0)
            $char="+";
        else
            $char="-";

        $date= new \DateTime();
        $date->setTime(rand(0,23), rand(0,59), rand(0,59));
        $date->modify("$char$days days");
       
       
        return $date;
    }
}