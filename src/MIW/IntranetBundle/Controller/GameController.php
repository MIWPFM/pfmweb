<?php

namespace MIW\IntranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use MIW\DataAccessBundle\Document\User;
use MIW\DataAccessBundle\Document\Game;
use MIW\DataAccessBundle\Document\Center;
use MIW\DataAccessBundle\Document\Address;
use MIW\IntranetBundle\Form\Type\GameType;

class GameController extends Controller
{
    /**
     * @Route("/partidos",name="intranet_games")
     * @Template("MIWIntranetBundle:Game:showGames.html.twig");
     */
    public function showGamesAction()
    {

        return array();
    }
    
    /**
     * @Route("/partidos/organizar",name="intranet_create_game")
     * @Template("MIWIntranetBundle:Game:createGame.html.twig");
     */
    public function createGameAction(Request $request)
    {
        
        // get user
        $user = $this->get('security.context')->getToken()->getUser();
        
        // create new game
        $game= new Game();
        $center= new Center();
        $address= new Address();
        $game->setAdmin($user);
        $center->setAddress($address);
        $game->setCenter($center);

        // get form
        $form = $this->createForm(new GameType(), $game);
        if($request->getMethod()=="POST"){
            $form->handleRequest($request);
            if ($form->isValid()) {  
                $dm = $this->get('doctrine.odm.mongodb.document_manager');

                $centerName=$game->getCenter()->getName();
                $center=$dm->getRepository('MIWDataAccessBundle:Center')->findOneByName($centerName);
               
                if(!$center)
                    $dm->persist($game->getCenter());
                else
                    $game->setCenter($center);
                        
                $dm->persist($game);
                $dm->flush();

                return $this->redirect($this->generateUrl('intranet_games'));
            }
        }
        
        return array('form'=>$form->createView(),'game'=>$game);
    }
    
}
