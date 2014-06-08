<?php

namespace MIW\DataAccessBundle\DataFixtures\ODM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MIW\DataAccessBundle\Document\Center;
use MIW\DataAccessBundle\Document\Address;
use MIW\DataAccessBundle\Document\Coordinates;

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
        $address->setAddress('Calle del Perú 17');
        $address->setZipcode(28823);
        $address->setCommunity("Comunidad de Madrid");
        $address->setProvince("Madrid");
        $address->setCity("Coslada");
        $coordinates= new Coordinates();
        $coordinates->setX(40.4298909);
        $coordinates->setY(-3.5406173);
        $address->setCoordinates($coordinates);
        $center->setAddress($address);
        $manager->persist($center);
        $manager->flush();
        
        $center2 = new Center();
        $center2->setName("Centro Deportivo Municipal Barajas");
        $center2->setDescription("Polideportivo en Barajas");
        $address= new Address();
        $address->setAddress('Avenida de Logroño 70');
        $address->setZipcode(28042);
        $address->setCommunity("Comunidad de Madrid");
        $address->setProvince("Madrid");
        $address->setCity("Barajas");
        $coordinates= new Coordinates();
        $coordinates->setX(40.4595213);
        $coordinates->setY(-3.5953203,17);
        $address->setCoordinates($coordinates);
        $center2->setAddress($address);
        $manager->persist($center2);
        $manager->flush();
        
        $center3 = new Center();
        $center3->setName("Centro Deportivo Municipal Entrevías");
        $center3->setDescription("Polideportivo en Vallecas");
        $address= new Address();
        $address->setAddress('Ronda del Sur 4');
        $address->setZipcode(28053);
        $address->setCommunity("Comunidad de Madrid");
        $address->setProvince("Madrid");
        $address->setCity("Vallecas");
        $coordinates= new Coordinates();
        $coordinates->setX(40.416598);
        $coordinates->setY(-3.656455);
        $address->setCoordinates($coordinates);
        $center3->setAddress($address);
        $manager->persist($center3);
        $manager->flush();
        
        $center4 = new Center();
        $center4->setName("Centro Deportivo Municipal La Elipa");
        $center4->setDescription("Polideportivo en La Elipa");
        $address= new Address();
        $address->setAddress('Parque de la Elipa 6');
        $address->setZipcode(28030);
        $address->setCommunity("Comunidad de Madrid");
        $address->setProvince("Madrid");
        $address->setCity("Moratalaz");
        $coordinates= new Coordinates();
        $coordinates->setX(40.378417);
        $coordinates->setY(-3.674526);
        $address->setCoordinates($coordinates);
        $center4->setAddress($address);
        $manager->persist($center4);
        $manager->flush();
        
        $center5 = new Center();
        $center5->setName("Centro Deportivo Municipal Luis Aragonés");
        $center5->setDescription("Polideportivo Hortaleza");
        $address= new Address();
        $address->setAddress('Calle el Provencio 20');
        $address->setZipcode(28043);
        $address->setCommunity("Comunidad de Madrid");
        $address->setProvince("Madrid");
        $address->setCity("Hortaleza");
        $coordinates= new Coordinates();
        $coordinates->setX(40.416598);
        $coordinates->setY(-    3.656455);
        $address->setCoordinates($coordinates);
        $center5->setAddress($address);
        $manager->persist($center5);
        $manager->flush();
           
        $this->addReference('center', $center);
        $this->addReference('center2', $center2);
        $this->addReference('center3', $center3);
        $this->addReference('center4', $center4);
        $this->addReference('center5', $center5);
    }
}