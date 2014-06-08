<?php

namespace MIW\IntranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MIW\DataAccessBundle\Document\User;
use MIW\DataAccessBundle\Document\Sport;
use MIW\DataAccessBundle\Document\Address;
use MIW\DataAccessBundle\Document\Coordinates;
use MIW\IntranetBundle\Form\Type\UserType;
use MIW\IntranetBundle\Form\Type\AddressType;
use MIW\IntranetBundle\Form\Type\PasswordType;

class MyProfileController extends Controller {

    /**
     * @Route("/mis-datos",name="intranet_myprofile_info")
     * @Template("MIWIntranetBundle:MyProfile:myInfo.html.twig")
     */
    public function viewMyInfoAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        $address = $user->getAddress();
        if ($address == null) {
            $address = new Address();
        }

        // create forms
        $formUser = $this->createForm(new UserType(), $user);
        $formAddress = $this->createForm(new AddressType(), $address);
        $formPassword = $this->createForm(new PasswordType());

        if ($request->getMethod() == "POST") {
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $formUser->handleRequest($request);
            $formAddress->handleRequest($request);
            $formPassword->handleRequest($request);

            if ($formUser->isValid()) {
                $user->setName($formUser->get('name')->getData());
                $user->setBirthday($formUser->get('birthday')->getData());
                $user->setEmail($formUser->get('email')->getData());
                $dm->persist($user);
                $dm->flush();
                return $this->redirect($this->generateUrl('intranet_myprofile_info'));
            }

            if ($formAddress->isValid()) {
                $address->setAddress($formAddress->get('address')->getData());
                $address->setCommunity($formAddress->get('community')->getData());
                $address->setProvince($formAddress->get('province')->getData());
                $address->setCity($formAddress->get('city')->getData());
                $address->setZipcode($formAddress->get('zipcode')->getData());
                $coordinates= new Coordinates();
                $coordinates->setX($formAddress->get('coordinates')->get('x')->getData());
                $coordinates->setY($formAddress->get('coordinates')->get('y')->getData());
                $address->setCoordinates($coordinates);
                $user->setAddress($address);
                $dm->persist($user);
                $dm->flush();
                return $this->redirect($this->generateUrl('intranet_myprofile_info'));
            }

            if ($formPassword->isValid()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($formPassword->get('passwordNew')->getData(), $user->getSalt());
                $user->setPassword($password);
                $dm->persist($user);
                $dm->flush();
                return $this->redirect($this->generateUrl('intranet_myprofile_info'));
            }
        }

        return array('formUser' => $formUser->createView(),
            'formAddress' => $formAddress->createView(),
            'formPassword' => $formPassword->createView());
    }

    /**
     * @Route("/mis-deportes",name="intranet_myprofile_sports")
     * @Template("MIWIntranetBundle:MyProfile:mySports.html.twig")
     */
    public function viewMySportsAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $mySports = $user->getSports();
        
        $arraySports = array();
        $arrayNotSports = array();
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
        
        return array('mySports' => $arraySports, 'myNotSports' => $arrayNotSports);
    }

    /**
     * @Route("/mis-partidos",name="intranet_myprofile_games")
     * @Template("MIWIntranetBundle:MyProfile:myGames.html.twig")
     */
    public function viewMyGamesAction() {
        $user = $this->get('security.context')->getToken()->getUser();

        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $ownerGames = $dm->getRepository('MIWDataAccessBundle:Game')->findUserGames($user);
        $playingGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayingGames($user);
        $playedGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayedGames($user);

        return array('ownerGames' => $ownerGames,
            'playingGames' => $playingGames,
            'playedGames' => $playedGames);
    }

    /**
     * @Route("/mis-partidos/organizados",name="intranet_myprofile_games_owner")
     * @Template("MIWIntranetBundle:MyProfile:ownerGames.html.twig")
     */
    public function viewMyOwnerGamesAction() {

        $user = $this->get('security.context')->getToken()->getUser();

        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $ownerGames = $dm->getRepository('MIWDataAccessBundle:Game')->findUserGames($user);

        return array('ownerGames' => $ownerGames);
    }

    /** 
     * @Route("/mis-partidos/por-jugar",name="intranet_myprofile_games_playing")
     * @Template("MIWIntranetBundle:MyProfile:playingGames.html.twig")
     */
    public function viewMyPlayingGamesAction() {
          
        $user = $this->get('security.context')->getToken()->getUser();
    
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $playingGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayingGames($user);

        return array('playingGames' => $playingGames);
    }

    /**
     * @Route("/mis-partidos/jugados",name="intranet_myprofile_games_played")
     * @Template("MIWIntranetBundle:MyProfile:playedGames.html.twig")
     */
    public function viewMyPlayedGamesAction() {
        $user = $this->get('security.context')->getToken()->getUser();

        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $playedGames = $dm->getRepository('MIWDataAccessBundle:Game')->findPlayedGames($user);

        return array('playedGames' => $playedGames);
    }

    /**
     * @Route("/upload-avatar",name="intranet_myprofile_upload_avatar")
     * @Template("MIWIntranetBundle:MyProfile:myMessages.html.twig")
     */
    public function uploadAvatarAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $avatar = $request->files->get('avatar');
 
        $mimeType=$avatar->getMimeType();

        if(strpos($mimeType,'image') !== false){
            $user->setImage($avatar);
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $user->uploadImage();
            $dm->persist($user);
            $dm->flush();
        }
        return $this->redirect($this->generateUrl('intranet_myprofile_info'));
    }
    
    

}
