<?php

namespace MIW\IntranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MIW\DataAccessBundle\Document\Sport;
class SportController extends Controller
{
    
    /**
        * @Route("/ajax/find/sport/",name="intranet_ajax_find_sport")
     */
    public function ajaxSearchSportAction(Request $request)
    {
        $value = $request->get('sport');
    
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $sport = $dm->getRepository('MIWDataAccessBundle:Sport')->find($value);

        $serializer = $this->get('jms_serializer');
        $data=$serializer->serialize($sport, 'json'); 
        
        $response = new Response();
        $response->setContent($data);

        return $response;
    }


}
