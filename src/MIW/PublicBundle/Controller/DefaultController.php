<?php

namespace MIW\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MIWPublicBundle:Default:index.html.twig', array('name' => $name));
    }
}
