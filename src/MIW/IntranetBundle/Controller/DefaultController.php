<?php

namespace MIW\IntranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MIWIntranetBundle:Default:index.html.twig', array('name' => $name));
    }
}
