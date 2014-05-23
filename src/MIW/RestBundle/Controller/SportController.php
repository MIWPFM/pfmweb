<?php

namespace MIW\RestBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\Prefix,
    FOS\RestBundle\Controller\Annotations\NamePrefix,
    FOS\RestBundle\Controller\Annotations\RouteResource,
    FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use MIW\DataAccessBundle\Document\Sport;
use MIW\DataAccessBundle\Document\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of SportController
 *
 */
class SportController extends FOSRestController {
    
    /**
     * @Rest\GET("/sports")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getSportsAction() {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $sports = $dm->getRepository('MIWDataAccessBundle:Sport')->findAll();

        if ($sports) {
            return $this->view($sports, 200);
        } else {
            throw new NotFoundHttpException();
        }
    }
    
    /**
     * @Rest\GET("/me/sports")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getSportsUserAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        
        if ($user != "anon.") {
            $arraySports = array();
            $arrayNotSports = array();
            $mySports = $user->getSports();
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $arrayAllSports = $dm->getRepository('MIWDataAccessBundle:Sport')->findAll();
            
            if (!empty($mySports)) {
                $arrayIdsSports = array();
                foreach ($mySports as $obj_key => $array) {
                    $arrayIdsSports[] = $obj_key;
                    $sport = $dm->getRepository('MIWDataAccessBundle:Sport')->find($obj_key);
                    $level = 0;
                    $position = null;  
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
                    $arraySports[] = array(
                        'sport' => $sport,
                        'level' => $level,
                        'position' => $position
                    );
                }
                foreach ($arrayAllSports as $array) {
                    $idSport = $array->getId();
                    if(!in_array($idSport, $arrayIdsSports)) {
                        $arrayNotSports[] = $array;
                    }
                }
            } else {
                $arrayNotSports = $arrayAllSports;
            }
            
            $arrayResult = array('mySports' => $arraySports, 'myNotSports' => $arrayNotSports);
            return $this->view($arrayResult, 200);
            
        } else {
            throw new NotFoundHttpException();
        }        
    }
    
    /**
     * @Rest\DELETE("/sport/{id, name}")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function deleteSportAction($id, $name) {
        $user = $this->get('security.context')->getToken()->getUser();  

        if($user == "anon.") {
            throw new NotFoundHttpException();
        } else {
            
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $user->removeSport($id);
            $dm->persist($user);
            $dm->flush(); 
            
            $result = array('id' => $id, 'name' => $name);
            return $this->view($result, 200)->setFormat('json');
        }
    }
    
    /**
     * @Rest\PUT("/sport/{id, name, level}")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function putSportAction($id, $name, $level) {
        $user = $this->get('security.context')->getToken()->getUser(); 
        
        if($user == "anon.") {
            throw new NotFoundHttpException();
        } else {
            
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $user->addSport($id, array('level'=>$level));
            $dm->persist($user);
            $dm->flush(); 
            
            $result = array(
                'id' => $id,
                'name' => $name,
                'level' => $level
            );        
            return $this->view($result, 200)->setFormat('json');
        }
    }
    
    /**
     * @Rest\POST("/sport/{id, name, level}")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function postSportAction($id, $name, $level) {
        $user = $this->get('security.context')->getToken()->getUser();  
        
        if($user == "anon.") {
            throw new NotFoundHttpException();
        } else {
            
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $user->addSport($id, array('level'=>$level));
            $dm->persist($user);
            $dm->flush(); 
            
            $result = array(
                'id' => $id,
                'name' => $name,
                'level' => $level
            );        
            return $this->view($result, 200)->setFormat('json');
        }
    }
    
}
