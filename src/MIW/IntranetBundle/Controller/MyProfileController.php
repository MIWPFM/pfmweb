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
        return array();
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
