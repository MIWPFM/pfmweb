<?php

namespace MIW\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller
{
    /**
     * @Route("/registrarse")
     * @Template("MIWPublicBundle:User:login.html.twig");
     */
    public function registerAction()
    {
        return array();
    }
    
    /**
     * @Route("/conectarse")
     * @Template("MIWPublicBundle:User:login.html.twig");
     */
    public function loginAction()
    {
        return array();
    }
}
