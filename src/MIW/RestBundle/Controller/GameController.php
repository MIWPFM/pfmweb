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
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getRecommendedGamesAction() {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        
        $lat=40.40;
        $long=-3.54;
        
        $nearCenters = $dm->getRepository('MIWDataAccessBundle:Center')->findClosestCenters($lat,$long);
        $geolocationService=$this->get('geolocation_service');
        
        $recommendedGames=array();

        foreach ($nearCenters as $key => $center) {
          
           $games=$dm->getRepository('MIWDataAccessBundle:Game')->findAllByCenter($center);
           $coordinates=$center->getAddress()->getCoordinates();
           foreach ($games as $game) {
               $line=array();
               $line['distance']=$geolocationService->getDistance($lat,$long,$coordinates->getX(),$coordinates->getY(),"K");
               $line['game']=$game;
               $recommendedGames[]=$line;
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

   
}
