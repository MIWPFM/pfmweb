<?php

namespace MIW\RestBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Prefix,
    FOS\RestBundle\Controller\Annotations\NamePrefix,
    FOS\RestBundle\Controller\Annotations\RouteResource,
    FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Request\ParamFetcher;
use MIW\DataAccessBundle\Document\User;


class GameController extends FOSRestController {

    /**
     * @Rest\GET("/game/{id}")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getGameAction($id) {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $game = $dm->getRepository('MIWDataAccessBundle:Game')->find($id);

        if ($game) {
            return $this->view($game, 200);
        } else {
            throw new NotFoundHttpException();
        }
    }
    
    /**
     * @Rest\GET("/me/recommended-games")
     * @QueryParam(name="lat", nullable=true)
     * @QueryParam(name="long", nullable=true)
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getRecommendedGamesAction(ParamFetcher $paramFetcher) {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if ($user == "anon.") {
            throw new NotFoundHttpException();
        }

        $lat=($paramFetcher->get('lat')!=null) ? floatval($paramFetcher->get('lat')) :$user->getAddress()->getCoordinates()->getX();
        $long=($paramFetcher->get('long')!=null) ? floatval($paramFetcher->get('long')) : $user->getAddress()->getCoordinates()->getY();

 
        if (!isset($lat) || !isset($long)) {
            throw new NotFoundHttpException(" Debe haber alguna localización");
        }

        $nearCenters = $dm->getRepository('MIWDataAccessBundle:Center')->findClosestCenters($lat,$long);
        $geolocationService=$this->get('geolocation_service');
        
        $recommendedGames=array();
        $sports=$user->getSports();
        
        
        $sportsKey= (is_array($sports) ? array_keys($sports): array());

        foreach ($nearCenters as $center) {
          
           $games=$dm->getRepository('MIWDataAccessBundle:Game')->findAllByCenterAndSports($center,$sportsKey);
           $coordinates=$center->getAddress()->getCoordinates();
          
           if(count($games) > 0){
                foreach ($games as $game) {
                    $line=array();
                    $line['distance']=$geolocationService->getDistance($lat,$long,$coordinates->getX(),$coordinates->getY(),"K");
                    $line['game']=$game;
                    $recommendedGames[]=$line;
                }
           }
        }

        return $this->view($recommendedGames, 200);
    }
    
    /**
     * @Rest\GET("/me/playing-games")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getPlayigGamesAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($user=="anon.")
              throw new NotFoundHttpException();
        
        // querys of games
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $playingGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayingGames($user);
         
        return $this->view($playingGames->toArray(), 200);
    }
    
        
    /**
     * @Rest\GET("/me/played-games")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getPlayedGamesAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($user=="anon.")
              throw new NotFoundHttpException();
        
        // querys of games
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $playedGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayedGames($user);
         
        return $this->view($playedGames->toArray(), 200);
    }

        /**
     * @Rest\GET("/me/organized-games")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getOrganizedGamesAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($user=="anon.")
              throw new NotFoundHttpException();
        
        // querys of games
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $organizedGames = $dm->getRepository('MIWDataAccessBundle:Game')->findUserGames($user);
         
        return $this->view($organizedGames->toArray(), 200);
    }
    
    /**
     * @Rest\GET("/me/next-games")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getGamesUserAction() {
        $user = $this->get('security.context')->getToken()->getUser(); 
        
        if($user == "anon.") {
              throw new NotFoundHttpException();
        } else {
            
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $today = new \DateTime('now');

        $nextMonth = clone $today;
        $nextMonth->add(new \DateInterval('P30D'));
        $nextMonth->setTime(0, 0, 0);
        $games = $dm->getRepository('MIWDataAccessBundle:Game')->findAllBetweenDates($today, $nextMonth, $user->getId());
 
        return $this->view($games->toArray(), 200);
        }
    }
    
    /**
     * @Rest\DELETE("/game/{id}")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function deleteGameAction($id) {            
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $game = $dm->getRepository('MIWDataAccessBundle:Game')->find($id);
        $dm->remove($game);
        $dm->flush(); 
            
        $result = array('id' => $id);
        return $this->view($result, 200)->setFormat('json');
    }
    
    /**
     * @Rest\PUT("/game/suscribe/{id}")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function putSuscribeGameAction($id) {
        $user = $this->get('security.context')->getToken()->getUser(); 
        
        if($user == "anon.") {
            throw new NotFoundHttpException();
        } else {
            
            $code = 0;
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $game = $dm->getRepository('MIWDataAccessBundle:Game')->find($id);
            if (!$game->getPlayers()->contains($user)) {
                $game->addPlayer($user);
                $code = 1;
            }
            $dm->persist($game);
            $dm->flush();
            
            $gamePlaces = $game->getNumPlayers();
            $places = count($game->getPlayers()) + 1;
            $serializer = $this->get('jms_serializer');
            $data = $serializer->serialize($user, 'json');
            
            $result = array('code' => $code, 
                            'places' => "$places/$gamePlaces", 
                            'user' => $data);
            return $this->view($result, 200)->setFormat('json');
        }
    }
    
    /**
     * @Rest\PUT("/game/unsuscribe/{id}")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function putUnsuscribeGameAction($id) {
        $user = $this->get('security.context')->getToken()->getUser();   
        
        if($user == "anon.") {
            throw new NotFoundHttpException();
        } else {
            
            $code = 0;
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $game = $dm->getRepository('MIWDataAccessBundle:Game')->find($id);
            if ($game->getPlayers()->contains($user)) {
                $game->removePlayer($user);
                $code = 1;
            }
            $dm->persist($game);
            $dm->flush();
            
            $gamePlaces = $game->getNumPlayers();
            $places = count($game->getPlayers()) + 1;
            $serializer = $this->get('jms_serializer');
            $data = $serializer->serialize($user, 'json');
            
            $result = array('code' => $code, 
                            'places' => "$places/$gamePlaces", 
                            'user' => $data);
            return $this->view($result, 200)->setFormat('json');
        }
    }
    
}
