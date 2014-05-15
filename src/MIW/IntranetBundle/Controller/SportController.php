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
    public function ajaxsubscribeSportAction(Request $request) {
        $idSport = $request->get('sport');
        var_dump($idSport);
        $myLevel = $request->get('level');
        $user = $this->get('security.context')->getToken()->getUser();        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        //no funciona
        $sports = $user->getSports();
        echo " deportes: ".$sports;
        $newSport = array($idSport=>array('level'=>$myLevel));
        echo " nuevo: ".$newSport;
        $result = array_push($sports, $newSport);
        echo " final: ".$sports;
        $user->setSports($sports);
        $dm->persist($user);
        $dm->flush();   
    }
    
    public function modifySportAction(Request $request) {
        $idSport = $request->get('idSport');
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $sport = $dm->getRepository('MIWDataAccessBundle:Sport')->find($idSport);
        $name = $sport->getName();//no funciona
                
        $user = $this->get('security.context')->getToken()->getUser();
        $mySports = $user->getSports();        
        foreach ($mySports as $obj_key => $array) {
            if($obj_key == $idSport) {
                foreach ($array as $key => $value) {
                    switch ($key) {
                        case "level":
                            $level = $value;
                            break;
                        case "position":
                            $position = $value;
                            break;
                    }
                }
            }
        }
                
        return $this->container->get('templating')->renderResponse('MIWIntranetBundle:Sport:editSport.html.twig', 
                array('form' => $form->createView(), 'idSport' => $idSport, 'name' => $name, 'level' => $level, 'position' => $position));
    }
    
    /**
        * @Route("/ajax/edit/sport/",name="intranet_ajax_edit_sport")
     */
    public function ajaxeditSportAction(Request $request) {
        $mySport = $request->get('sport');
        $myLevel = $request->get('level');
        $user = $this->get('security.context')->getToken()->getUser();        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $sports = $user->getSports();
        $newSport = array($mySport=>array('level'=>$myLevel));
        $result = array_push($sports, $newSport);
        $user->setSports($sports);
        $dm->persist($user);
        $dm->flush();          
    }
    
    /**
        * @Route("/ajax/delete/sport/",name="intranet_ajax_delete_sport")
     */
    public function ajaxdeleteSportAction(Request $request) {
        $mySport = $request->get('sport');
        $myLevel = $request->get('level');
        $user = $this->get('security.context')->getToken()->getUser();        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $sports = $user->getSports();
        $newSport = array($mySport=>array('level'=>$myLevel));
        $result = array_push($sports, $newSport);
        $user->setSports($sports);
        $dm->persist($user);
        $dm->flush();      
    }
    
}
