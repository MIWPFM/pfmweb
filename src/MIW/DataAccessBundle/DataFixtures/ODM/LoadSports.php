<?php

namespace MIW\DataAccessBundle\DataFixtures\ODM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MIW\DataAccessBundle\Document\Sport;

class LoadSports extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder(){
        return 1;
    }
    
   /* php app/console doctrine:mongodb:fixtures:load --fixtures src/MIW/DataAccessBundle/DataFixtures/ODM */
    public function load(ObjectManager $manager){
        print_r("Loading Sports\n");
        $football = new Sport();
        $football->setName("Futbol");
        $football->setDescription("ATLEEEETI!!!");
        $football->setMinPlayers(22);
        $football->setLevel(5);
        $football->setAttributes(array('position'=>array('Portero','Defensa','Centrocampista','Delantero')));
       
        $manager->persist($football);
    	$manager->flush();
        
        $beisbol = new Sport();
        $beisbol->setName("Beisbol");
        $beisbol->setDescription("CUBA - USA");
        $beisbol->setMinPlayers(18);
        $beisbol->setLevel(5);
        $beisbol->setAttributes(array('position'=>array('1Base','2Base','3Base','Pitcher')));
       
        $manager->persist($beisbol);
    	$manager->flush();
        
        $paddel = new Sport();
        $paddel->setName("Padel");
        $paddel->setDescription("Juego de raquetas");
        $paddel->setMinPlayers(2);
        $paddel->setLevel(5);
        $paddel->setAttributes(array('position'=>array('Izquierda','Derecha')));
       
        $manager->persist($paddel);
    	$manager->flush();
        
        $basket = new Sport();
        $basket->setName("Baloncesto");
        $basket->setDescription("Juego de basketball");
        $basket->setMinPlayers(10);
        $basket->setLevel(5);
        $basket->setAttributes(array('position'=>array('Base','Escolta','Alero','Ala-Pívot','Pívot')));
       
        $manager->persist($basket);
    	$manager->flush();
        
        $voleyball = new Sport();
        $voleyball->setName("Voleyball");
        $voleyball->setDescription("Juego de Voleyball");
        $voleyball->setMinPlayers(12);
        $voleyball->setLevel(5);
        $voleyball->setAttributes(array('position'=>array('Izquierda','Derecha','Central','Defensa')));
       
        $manager->persist($voleyball);
    	$manager->flush();
        
        $this->addReference('football', $football);
        $this->addReference('beisbol', $beisbol);
        $this->addReference('paddel', $paddel);
        $this->addReference('basket', $basket);
        $this->addReference('voleyball', $voleyball);
    }
}