<?php

namespace MIW\IntranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MIW\DataAccessBundle\Document\Sport;
use MIW\IntranetBundle\Form\Type\SportType;

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
    
    /**
        * @Route("/ajax/add/sport/",name="intranet_ajax_add_sport")
     */
    public function ajaxAddSportAction(Request $request) {
        $idSport = $request->get('id');
        $nameSport = $request->get('name');
        $myLevel = $request->get('level');
        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');        
        $user = $this->get('security.context')->getToken()->getUser();
        $user->addSport($idSport, array('level'=>$myLevel));
        $dm->persist($user);
        $dm->flush();   
        
        $json = array(
                'id' => $idSport,
                'name' => $nameSport,
                'level' => $myLevel
        );        
        $response = new Response();
        $response->setContent(json_encode($json));
        return $response;
    }
    
    /**
        * @Route("/ajax/delete/sport/",name="intranet_ajax_delete_sport")
     */
    public function ajaxDeleteSportAction(Request $request) {
        $idSport = $request->get('id');        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');        
        $user = $this->get('security.context')->getToken()->getUser();
        $user->removeSport($idSport);
        $dm->persist($user);
        $dm->flush();   
        
        $json = array('id' => $idSport);        
        $response = new Response();
        $response->setContent(json_encode($json));
        return $response;
    }
    
}
