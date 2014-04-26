<?php

namespace MIW\IntranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use MIW\DataAccessBundle\Document\User;
use MIW\DataAccessBundle\Document\Game;

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
    public function createGameAction()
    {
        $game= new Game();

        return array('game'=>$game);
    }
    
}
