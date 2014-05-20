<?php

namespace MIW\DataAccessBundle\DataFixtures\ODM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MIW\DataAccessBundle\Document\User;
use MIW\DataAccessBundle\Document\Address;
use MIW\DataAccessBundle\Document\Coordinates;
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
        $beisbol= $this->getReference('beisbol');
        
        $user = new User();
        $user->setUsername('alonsus91');
        $user->setEmail('alonsus91@gmail.com');
        $user->setRoles(array('ROLE_USER'));
        $user->setName('Adrian');
        $user->setSports(array($football->getId()=>array('position'=>'Defensa', 'level'=>3),
                                $paddel->getId() => array('position'=>'Izquierda', 'level'=>1),
                                $beisbol->getId() => array('position'=>'Pitcher', 'level'=>5)));
        $password = 'admin';
        
        $address= new Address();
        $address->setAddress("C\Perú 22 4º 1");
        $address->setCity("Madrid");
        $coordinates= new Coordinates();
        $coordinates->setX(40.4298909);
        $coordinates->setY(-3.5406173);
        $address->setCoordinates($coordinates);
  
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
        $user2->setSports(array($football->getId()=>array('position'=>'Defensa', 'level'=>3),
                                $paddel->getId() => array('position'=>'Izquierda', 'level'=>1),
                                $beisbol->getId() => array('position'=>'Pitcher', 'level'=>5)));
        
        $cryptedPassword2 = $encoder->encodePassword($password, $user2->getSalt());
        $user2->setPassword($cryptedPassword2);
        $user2->setAddress($address);
        $user2->setEnabled(true);
        
        $user3 = new User();
        $user3->setUsername('alberto');
        $user3->setEmail('albertoMIW@gmail.com');
        $user3->setRoles(array('ROLE_USER'));
        $user3->setName('Alberto');
        $user3->setSports(array($football->getId()=>array('position'=>'Defensa', 'level'=>3),
                                $paddel->getId() => array('position'=>'Izquierda', 'level'=>3)));
        
        $cryptedPassword3 = $encoder->encodePassword($password, $user3->getSalt());
        $user3->setPassword($cryptedPassword3);
        $user3->setAddress($address);
        $user3->setEnabled(true);
        
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(array('ROLE_USER','ROLE_ADMIN'));
        $admin->setName('Administrador');
      
        $cryptedPassword3 = $encoder->encodePassword('admin', $admin->getSalt());
        $admin->setPassword($cryptedPassword3);
        $admin->setEnabled(true);

        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($admin);
    	$manager->flush();
        
        $this->addReference('user', $user);
        $this->addReference('user2', $user2);
        $this->addReference('user3', $user3);
    }
}