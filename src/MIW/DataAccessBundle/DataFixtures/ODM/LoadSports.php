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
        $football->setName("Futbol 11");
        $football->setDescription("Juego de pelota blabla");
        $football->setMinPlayers(11);
        $football->setAttributes(array('level'=>array('Aficionado','Intermedio','Profesional'),
                                'position'=>array('Portero','Defensa','Centrocampista','Delantero')));
       
        $manager->persist($football);
    	$manager->flush();
        
        $paddel = new Sport();
        $paddel->setName("Padel");
        $paddel->setDescription("Juego de raquetas");
        $paddel->setMinPlayers(2);
        $paddel->setAttributes(array('level'=>array('Aficionado','Intermedio','Profesional')));
       
        $manager->persist($paddel);
    	$manager->flush();

        $this->addReference('football', $football);
        $this->addReference('paddel', $paddel);
    }
}