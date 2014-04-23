<?php

namespace MIW\DataAccessBundle\DataFixtures\ODM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MIW\DataAccessBundle\Document\User;
use MIW\DataAccessBundle\Document\Address;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function getOrder(){
        return 2;
    }
   /* php app/console doctrine:mongodb:fixtures:load --fixtures src/MIW/DataAccessBundle/DataFixtures/ODM */
    public function load(ObjectManager $manager){
        print_r("Loading Users\n");
        
        $football= $this->getReference('football');
        $paddel= $this->getReference('paddel');
        
        $user = new User();
        $user->setUsername('alonsus91');
        $user->setEmail('alonsus91@gmail.com');
        $user->setRoles(array('ROLE_USER'));
        $user->setName('Adrian');
        $user->setSports(array($football->getId()=>array('position'=>"Delantero",'level'=>"Profesional"),
                                $paddel->getId() => array('level'=>"Aficionado")));
        $password = 'admin';
        
        $address= new Address();
        $address->setAddress("C\Perú 22 4º 1");
        $address->setCity("Madrid");
        $address->setCountry("España");
        $address->setLat(40.4);
        $address->setLong(-3.4);
        $address->setProvince("Madrid");
        
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $cryptedPassword = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($cryptedPassword);
        $user->setAddress($address);
        $user->setEnabled(true);
        
        $user2 = new User();
        $user2->setUsername('lien');
        $user2->setEmail('lienMIW@gmail.com');
        $user2->setRoles(array('ROLE_USER'));
        $user2->setName('Lien');
        $user2->setSports(array($football->getId()=>array('position'=>"Delantero",'level'=>"Profesional"),
                                $paddel->getId() => array('level'=>"Aficionado")));
        
        $cryptedPassword2 = $encoder->encodePassword($password, $user2->getSalt());
        $user2->setPassword($cryptedPassword2);
        $user2->setAddress($address);
        $user2->setEnabled(true);

        $manager->persist($user);
        $manager->persist($user2);
    	$manager->flush();
        
        $this->addReference('user', $user);
        $this->addReference('user2', $user2);
    }
}