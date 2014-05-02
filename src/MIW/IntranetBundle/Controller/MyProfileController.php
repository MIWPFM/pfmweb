<?php

namespace MIW\IntranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MyProfileController extends Controller
{
    /**
     * @Route("/mis-datos",name="intranet_myprofile_info")
     * @Template("MIWIntranetBundle:MyProfile:myInfo.html.twig")
     */
    public function viewMyInfoAction()
    {
        return array();
    }
    /**
     * @Route("/mis-deportes",name="intranet_myprofile_sports")
     * @Template("MIWIntranetBundle:MyProfile:mySports.html.twig")
     */
    public function viewMySportsAction()
    {
        return array();
    }
    
    /**
     * @Route("/mis-partidos",name="intranet_myprofile_games")
     * @Template("MIWIntranetBundle:MyProfile:myGames.html.twig")
     */
    public function viewMyGamesAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $ownerGames = $dm->getRepository('MIWDataAccessBundle:Game')->findUserGames($user);
        $playingGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayingGames($user);
        $playedGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayedGames($user);
            
        return array('ownerGames'=>$ownerGames,
                    'playingGames'=>$playingGames,
                    'playedGames'=>$playedGames);
    }
    
    /**
     * @Route("/mis-partidos/organizados",name="intranet_myprofile_games_owner")
     * @Template("MIWIntranetBundle:MyProfile:ownerGames.html.twig")
     */
    public function viewMyOwnerGamesAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $ownerGames = $dm->getRepository('MIWDataAccessBundle:Game')->findUserGames($user);
       
            
        return array('ownerGames'=>$ownerGames);
    }
    
        /**
     * @Route("/mis-partidos/por-jugar",name="intranet_myprofile_games_playing")
     * @Template("MIWIntranetBundle:MyProfile:playingGames.html.twig")
     */
    public function viewMyPlayingGamesAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
       
        $playingGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayingGames($user);

            
        return array('playingGames'=>$playingGames);
    }
    
    /**
     * @Route("/mis-partidos/jugados",name="intranet_myprofile_games_played")
     * @Template("MIWIntranetBundle:MyProfile:playedGames.html.twig")
     */
    public function viewMyPlayedGamesAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
       
        $playedGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayedGames($user);

            
        return array('playedGames'=>$playedGames);
    }
    
    /**
     * @Route("/mis-mensajes",name="intranet_myprofile_messages")
     * @Template("MIWIntranetBundle:MyProfile:myMessages.html.twig")
     */
    public function viewMyMessagesAction()
    {
        return array();
    }

}
