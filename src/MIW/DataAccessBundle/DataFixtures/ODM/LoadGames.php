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
        return 3;
    }
   /* php app/console doctrine:mongodb:fixtures:load --fixtures src/MIW/DataAccessBundle/DataFixtures/ODM */
    public function load(ObjectManager $manager){
        print_r("Loading Games\n");
        $football= $this->getReference('football');
        $paddel= $this->getReference('paddel');
        $user= $this->getReference('user');
        $user2= $this->getReference('user2');
        
        $game = new Game();
        $game->setAdmin($user);
        $game->setCreated(new \DateTime());
        $game->setLimitDate(new \Datetime());
        $game->setPrice(10);
        $game->setNumPlayers(22);
        $game->setSport($football);
        $game->setDescription("Creo este evento en tal sitio por que quiero bla bla");
        $game->addPlayer($user2);
        
        $game2 = new Game();
        $game2->setAdmin($user2);
        $game2->setCreated(new \DateTime());
        $game2->setLimitDate(new \Datetime());
        $game2->setPrice(2);
        $game2->setNumPlayers(2);
        $game2->setSport($paddel);
        $game2->setDescription("Creo este evento en tal sitio por que quiero bla bla");
        $game2->addPlayer($user);
        
        $manager->persist($game);
        $manager->persist($game2);
    	$manager->flush();
        
        $this->addReference('game', $game);
        $this->addReference('game2', $game2);
    }
}