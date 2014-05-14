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
    
    public function createSportAction() {
        $form = $this->createForm(new SportType());
        return $this->container->get('templating')->renderResponse('MIWIntranetBundle:Sport:addSport.html.twig', 
                array('form' => $form->createView()));
    }
    
    /**
        * @Route("/ajax/subscribe/sport/",name="intranet_ajax_subscribe_sport")
     */
    public function subscribeSportAction(Request $request) {
        $mySport = $request->get('sport');
        $myLevel = $request->get('level');
        $user = $this->get('security.context')->getToken()->getUser();        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        //hacer un concat
        //$sports = $user->getSports();
        //$result = array_merge($sports, array($mySport=>array('level'=>$myLevel)));
        $user->setSports(array($mySport=>array('level'=>$myLevel)));
        $dm->persist($user);
        $dm->flush();   
    }
    
    public function modifySportAction() {
        $form = $this->createForm(new SportType());
        return $this->container->get('templating')->renderResponse('MIWIntranetBundle:Sport:editSport.html.twig', 
                array('form' => $form->createView()));
    }
    
    /**
        * @Route("/ajax/edit/sport/",name="intranet_ajax_edit_sport")
     */
    public function editSportAction(Request $request) {
        $mySport = $request->get('sport');
        $myLevel = $request->get('level');
        $user = $this->get('security.context')->getToken()->getUser();
        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');                
        $user->setSports(array($mySport->getId()=>array('level'=>$myLevel)));
        $dm->persist($user);
        $dm->flush();                
    }
    
    /**
        * @Route("/ajax/delete/sport/",name="intranet_ajax_delete_sport")
     */
    public function deleteSportAction(Request $request) {
        $mySport = $request->get('sport');
        $myLevel = $request->get('level');
        $user = $this->get('security.context')->getToken()->getUser();
        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');                
        $user->setSports(array($mySport->getId()=>array('level'=>$myLevel)));
        $dm->persist($user);
        $dm->flush();                
    }
    
}
