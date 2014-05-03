<?php

namespace MIW\DataAccessBundle\DataFixtures\ODM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MIW\DataAccessBundle\Document\Center;
use MIW\DataAccessBundle\Document\Address;

class LoadCenters extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
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
        print_r("Loading Centers\n");
        
        $center = new Center();
        $center->setName("Polideportivo Valleaguado");
        $center->setDescription("Polideportivo en Coslada");
        $address= new Address();
        $address->setAddress('Calle Perú 25,27');
        $address->setZipcode(28823);
        $address->setCommunity("Comunidad de Madrid");
        $address->setProvince("Madrid");
        $address->setCity("Coslada");
        $address->setLat(40.4298909);
        $address->setLong(-3.5406173);
        $center->setAddress($address);
        $manager->persist($center);
        $manager->flush();
           
        $this->addReference('center', $center);
    }
}