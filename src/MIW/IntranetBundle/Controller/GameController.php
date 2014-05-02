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
use Symfony\Component\HttpFoundation\Response;
use MIW\DataAccessBundle\Document\User;
use MIW\DataAccessBundle\Document\Game;
use MIW\DataAccessBundle\Document\Sport;
use MIW\DataAccessBundle\Document\Center;
use MIW\DataAccessBundle\Document\Address;
use MIW\IntranetBundle\Form\Type\GameType;
use MIW\IntranetBundle\Utility\Utility;
use DateTime;
use DateInterval;

class GameController extends Controller
{
    /**
     * @Route("/partidos",name="intranet_games")
     * @Template("MIWIntranetBundle:Game:showGames.html.twig");
     */
    public function showGamesAction()
    {
         // get user
        $user = $this->get('security.context')->getToken()->getUser();
        $idUser = $user->getId();
        
        // querys of games
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $today = new DateTime('now');
        $tomorrow = clone $today;
        $tomorrow->add(new DateInterval('P1D'));
        $tomorrow->setTime(0, 0, 0);
        $gamesToday = $dm->getRepository('MIWDataAccessBundle:Game')->findAllBetweenDates($today, $tomorrow, $idUser);
        
        $twodays = clone $today;
        $twodays->add(new DateInterval('P2D'));
        $twodays->setTime(0, 0, 0);
        $gamesTomorrow = $dm->getRepository('MIWDataAccessBundle:Game')->findAllBetweenDates($tomorrow, $twodays, $idUser);
        
        $week = clone $today;
        $week->add(new DateInterval('P7D'));
        $week->setTime(0, 0, 0);
        $gamesThisWeek = $dm->getRepository('MIWDataAccessBundle:Game')->findAllBetweenDates($twodays, $week, $idUser);
        
        $gamesCount = count($gamesToday) + count($gamesTomorrow) + count($gamesThisWeek);
        return array('gamesToday' => $gamesToday, 'gamesTomorrow' => $gamesTomorrow, 
                        'gamesThisWeek' => $gamesThisWeek, 'gamesCount' => $gamesCount);
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
                
                // Check if is a new center or not
                $centerName=$game->getCenter()->getName();
                $center=$dm->getRepository('MIWDataAccessBundle:Center')->findOneByName($centerName);
                if (!$center) {
                    $dm->persist($game->getCenter());
                } else
                    $game->setCenter($center);

                // Transform dates, possible move to event
                $gameDate=Utility::addTimeToDate($game->getGameDate(), $form->get('gameTime')->getData());
                $gameLimitDate=Utility::addTimeToDate($game->getLimitDate(), $form->get('limitTime')->getData());
                $game->setGameDate($gameDate);
                $game->setLimitDate($gameLimitDate);
                
                $dm->persist($game);
                $dm->flush();

                return $this->redirect($this->generateUrl('intranet_games'));
            }
        }
        
        return array('form'=>$form->createView(),'game'=>$game);
    }
    
    
}
