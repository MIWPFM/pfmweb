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
        $football->setDescription("Real Madrid - Barca");
        $football->setMinPlayers(12);
        $football->setLevel(5);
        $football->setAttributes(array('position'=>array('Portero','Defensa','Centrocampista','Delantero')));
       
        $manager->persist($football);
    	$manager->flush();
        
        $beisbol = new Sport();
        $beisbol->setName("Beisbol");
        $beisbol->setDescription("CUBA - USA");
        $beisbol->setMinPlayers(9);
        $beisbol->setLevel(3);
        $beisbol->setAttributes(array('position'=>array('1Base','2Base','3Base','Pitcher')));
       
        $manager->persist($beisbol);
    	$manager->flush();
        
        $paddel = new Sport();
        $paddel->setName("Padel");
        $paddel->setDescription("Juego de raquetas");
        $paddel->setMinPlayers(2);
        $paddel->setLevel(1);
        $paddel->setAttributes(array('level'=>array('Aficionado','Intermedio','Profesional')));
       
        $manager->persist($paddel);
    	$manager->flush();

        $this->addReference('football', $football);
        $this->addReference('beisbol', $beisbol);
        $this->addReference('paddel', $paddel);
    }
}