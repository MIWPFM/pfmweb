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
use MIW\DataAccessBundle\Document\Comment;
use MIW\DataAccessBundle\Document\Center;
use MIW\DataAccessBundle\Document\Address;
use MIW\IntranetBundle\Form\Type\GameType;
use MIW\IntranetBundle\Utility\Utility;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use DateTime;
use DateInterval;

class GameController extends Controller {

    /**
     * @Route("/partidos",name="intranet_games")
     * @Template("MIWIntranetBundle:Game:showGames.html.twig");
     */
    public function showGamesAction() {
        // get user
        $user = $this->get('security.context')->getToken()->getUser();
        $idUser = $user->getId();

        // querys of games
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $playingGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayingGames($user);

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


        return array('gamesToday' => $gamesToday, 'gamesTomorrow' => $gamesTomorrow,
            'gamesThisWeek' => $gamesThisWeek, 'playingGames' => $playingGames);
    }

    /**
     * @Route("/partidos/ver/{id}",name="intranet_games_show")
     * @Template("MIWIntranetBundle:Game:showGame.html.twig");
     */
    public function showGameAction($id) {

        // get game
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $game = $dm->getRepository('MIWDataAccessBundle:Game')->find($id);
        $comments = $dm->getRepository('MIWDataAccessBundle:Comment')->findAllByGame($game);

        if (!$game) {
            throw new NotFoundHttpException("Partido no encontrado");
        }

        return array('game' => $game,'comments'=>$comments);
    }

    /**
     * @Route("/partidos/organizar",name="intranet_create_game")
     * @Template("MIWIntranetBundle:Game:createGame.html.twig");
     */
    public function createGameAction(Request $request) {
        // get user
        $user = $this->get('security.context')->getToken()->getUser();

        // create new game
        $game = new Game();
        $center = new Center();
        $address = new Address();
        $game->setAdmin($user);
        $center->setAddress($address);
        $game->setCenter($center);

        // get form
        $form = $this->createForm(new GameType(), $game);
        if ($request->getMethod() == "POST") {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $dm = $this->get('doctrine.odm.mongodb.document_manager');

                // Check if is a new center or not
                $centerName = $game->getCenter()->getName();
                $center = $dm->getRepository('MIWDataAccessBundle:Center')->findOneByName($centerName);
                if (!$center) {
                    $dm->persist($game->getCenter());
                } else
                    $game->setCenter($center);

                // Transform dates, possible move to event
                $gameDate = Utility::addTimeToDate($game->getGameDate(), $form->get('gameTime')->getData());
                $gameLimitDate = Utility::addTimeToDate($game->getLimitDate(), $form->get('limitTime')->getData());
                $game->setGameDate($gameDate);
                $game->setLimitDate($gameLimitDate);

                $dm->persist($game);
                $dm->flush();

                return $this->redirect($this->generateUrl('intranet_games'));
            }
        }

        return array('form' => $form->createView(), 'game' => $game);
    }

    /**
     * @Route("/partidos/editar/{id}",name="intranet_edit_game")
     * @Template("MIWIntranetBundle:Game:editGame.html.twig");
     */
    public function editGameAction(Request $request, $id) {
        // get user
        $user = $this->get('security.context')->getToken()->getUser();

        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $game = $dm->getRepository('MIWDataAccessBundle:Game')->find($id);

        if ($game->getAdmin() != $user)
            throw new AccessDeniedException();

        // get form
        $form = $this->createForm(new GameType(), $game);
        if ($request->getMethod() == "POST") {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $dm = $this->get('doctrine.odm.mongodb.document_manager');

                // Check if is a new center or not
                $centerName = $game->getCenter()->getName();
                $center = $dm->getRepository('MIWDataAccessBundle:Center')->findOneByName($centerName);
                if (!$center) {
                    $dm->persist($game->getCenter());
                } else
                    $game->setCenter($center);

                // Transform dates, possible move to event
                $gameDate = Utility::addTimeToDate($game->getGameDate(), $form->get('gameTime')->getData());
                $gameLimitDate = Utility::addTimeToDate($game->getLimitDate(), $form->get('limitTime')->getData());
                $game->setGameDate($gameDate);
                $game->setLimitDate($gameLimitDate);

                $dm->persist($game);
                $dm->flush();

                return $this->redirect($this->generateUrl('intranet_games'));
            }
        }

        return array('form' => $form->createView(), 'game' => $game);
    }

    /**
     * @Route("/partidos/inscribirse",name="intranet_ajax_subscribe_game")
     */
    public function ajaxSubscribeGameAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $idGame = $request->get('game');
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $game = $dm->getRepository('MIWDataAccessBundle:Game')->find($idGame);

        // Check if the user suscribed to the game
        $now=new \DateTime('now');
        $code = 0;
        if (!$game->getPlayers()->contains($user)) {
            $game->addPlayer($user);
            $code = 1;
        }
        $dm->persist($game);
        $dm->flush();

        $gamePlaces = $game->getNumPlayers();
        $places = count($game->getPlayers()) + 1;
        $serializer = $this->get('jms_serializer');
        $data=$serializer->serialize($user, 'json');
        $json = array('code' => $code, 'places' => "$places/$gamePlaces",'user'=>$data);

        $response = new Response();
        $response->setContent(json_encode($json));
        return $response;
    }

    /**
     * @Route("/partidos/desinscribirse",name="intranet_ajax_unsubscribe_game")
     */
    public function ajaxUnsubscribeGameAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        $idGame = $request->get('game');

        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $game = $dm->getRepository('MIWDataAccessBundle:Game')->find($idGame);

        $code = 0;
        $now=new \DateTime('now');
        // Check if the user suscribed to the game
        if ($game->getPlayers()->contains($user)) {
            $game->removePlayer($user);
            $code = 1;
        }
        $dm->persist($game);
        $dm->flush();

        $gamePlaces = $game->getNumPlayers();
        $places = count($game->getPlayers()) + 1;
        $serializer = $this->get('jms_serializer');
        $data=$serializer->serialize($user, 'json');
        $json = array('code' => $code, 'places' => "$places/$gamePlaces",'user'=>$data);

        $response = new Response();
        $response->setContent(json_encode($json));
        return $response;
    }
    
    /**
     * @Route("/partidos/{idGame}/comentar",name="intranet_ajax_comment_game")
     */
    public function commentGameAjaxAction(Request $request,$idGame) {

        $user = $this->get('security.context')->getToken()->getUser();


        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $game = $dm->getRepository('MIWDataAccessBundle:Game')->find($idGame);

        $commentText = $request->get('comment');
        if($commentText){
            $comment= new Comment();
            $comment->setComment($commentText);
            $comment->setGame($game);
            $comment->setUser($user);
            $dm->persist($comment);
            $dm->flush();
            
            $pusher = $this->get('lopi_pusher.pusher');
            $serializer = $this->get('jms_serializer');

            $pusher->trigger('comments-channel', 'comments-'.$idGame, $serializer->serialize($comment, 'json'));
            
            return new Response(json_encode(array('result'=>"OK")));
        }
        
        throw new NotFoundHttpException();
        
    }
    
   

}
