<?php

namespace MIW\DataAccessBundle\DataFixtures\ODM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MIW\DataAccessBundle\Document\Comment;


class LoadComments extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function getOrder(){
        return 5;
    }
   /* php app/console doctrine:mongodb:fixtures:load --fixtures src/MIW/DataAccessBundle/DataFixtures/ODM */
    public function load(ObjectManager $manager){
        print_r("Loading Comments\n");
        $game= $this->getReference('game');
        $game2= $this->getReference('game2');
        $user= $this->getReference('user');
        $user2= $this->getReference('user2');
        
        $comment = new Comment();
        $comment->setComment("Me gusta");
        $comment->setUser($user);
        $comment->setCreated(new \Datetime());
        $comment->setGame($game);
        
        $comment2 = new Comment();
        $comment2->setComment("Eweewe");
        $comment2->setUser($user2);
        $comment2->setCreated(new \Datetime());
        $comment2->setGame($game);
        
        $comment3 = new Comment();
        $comment3->setComment("Yejee");
        $comment3->setUser($user);
        $comment3->setCreated(new \Datetime());
        $comment3->setGame($game2);
        
        $manager->persist($comment);
        $manager->persist($comment2);
        $manager->persist($comment3);
        $manager->flush();
    }
}