<?php

namespace MIW\RestBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Prefix,
    FOS\RestBundle\Controller\Annotations\NamePrefix,
    FOS\RestBundle\Controller\Annotations\RouteResource,
    FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Request\ParamFetcher;
use MIW\DataAccessBundle\Document\User;
use MIW\DataAccessBundle\Document\Coordinates;
use MIW\DataAccessBundle\Document\Address;
use MIW\IntranetBundle\Form\Type\UserType;
use MIW\IntranetBundle\Form\Type\AddressType;
use MIW\IntranetBundle\Form\Type\PasswordType;

class UserController extends FOSRestController {

    /**
     * @Rest\GET("/user/{username}")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getUserAction($username) {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $user = $dm->getRepository('MIWDataAccessBundle:User')->findOneByUsername($username);

        if ($user) {
            return $this->view($user, 200);
        } else
            return new NotFoundHttpException();
    }

    /**
     * @Rest\POST("/user")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function newUserAction() {

        return $this->processForm();
    }

    private function processForm() {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $form = $this->container->get('fos_user.registration.form');
        $form->bind($this->getRequest()->request->all());

        if ($form->isValid()) {
            $user = $form->getData();
            $statusCode = $user->getId() ? 204 : 201;

            if (201 === $statusCode) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);
                $user->setEnabled(true);
            }

            $dm->persist($user);
            $dm->flush();

            return $this->view($user, 201);
        }

        return $this->view($form, 400);
    }

    /**
     * @Rest\PUT("/me/info")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function putEditUserInfoAction() {
        $user = $this->get('security.context')->getToken()->getUser();

        if ($user == "anon.") {
            throw new NotFoundHttpException();
        } else {
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            
            $form = $this->createForm(new UserType(), $user,array('csrf_protection'=> false));
            $form->bind($this->getRequest()->request->all());

            if ($form->isValid()) {
                $user->setName($form->get('name')->getData());
                $user->setBirthday($form->get('birthday')->getData());
                $user->setEmail($form->get('email')->getData());

                $dm->persist($user);
                $dm->flush();

                return $this->view($user, 201);
            }

            return $this->view($form, 400);
        }
    }

    /**
     * @Rest\PUT("/me/location")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function putEditUserLocationAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $address = $user->getAddress();

        if ($user == "anon.") {
            throw new NotFoundHttpException();
        } else {
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            
            $form = $this->createForm(new AddressType(), $address,array('csrf_protection'=> false));
            $form->bind($this->getRequest()->request->all());

            if ($form->isValid()) {
                $address->setAddress($form->get('address')->getData());
                $address->setCommunity($form->get('community')->getData());
                $address->setProvince($form->get('province')->getData());
                $address->setCity($form->get('city')->getData());
                $address->setZipcode($form->get('zipcode')->getData());
                $coordinates= new Coordinates();
                $coordinates->setX($form->get('coordinates')->get('x')->getData());
                $coordinates->setY($form->get('coordinates')->get('y')->getData());
                $address->setCoordinates($coordinates);
                $user->setAddress($address);

                $dm->persist($user);
                $dm->flush();

                return $this->view($user, 201);
            }

            return $this->view($form, 400);
        }
    }

    /**
     * @Rest\PUT("/me/password")
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function putEditUserPasswordAction() {
        $user = $this->get('security.context')->getToken()->getUser();

        if ($user == "anon.") {
            throw new NotFoundHttpException();
        } else {
            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            
            $form = $this->createForm(new PasswordType());
            $form->bind($this->getRequest()->request->all());

            if ($form->isValid()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($form->get('passwordNew')->getData(), $user->getSalt());
                $user->setPassword($password);

                $dm->persist($user);
                $dm->flush();

                return $this->view($user, 201);
            }

            return $this->view($form, 400);
        }
    }

}
