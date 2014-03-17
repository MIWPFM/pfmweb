<?php

namespace MIW\DataAccessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MIWDataAccessBundle:Default:index.html.twig', array('name' => $name));
    }
}
