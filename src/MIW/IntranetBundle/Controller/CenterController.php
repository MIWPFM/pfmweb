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
use MIW\DataAccessBundle\Document\Game;
use MIW\DataAccessBundle\Document\Center;
use MIW\DataAccessBundle\Document\Address;
use MIW\IntranetBundle\Form\Type\GameType;

class CenterController extends Controller
{
    /**
     * @Route("/ajax/find/centers",name="intranet_ajax_search_center")
     */
    public function ajaxSearchCenterAction(Request $request)
    {
        $value = $request->get('center');
        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $centers = $dm->getRepository('MIWDataAccessBundle:Center')->findAllByNameRegex($value);

        $json = array();
        foreach ($centers as $center) {
            $json[] = array(
                'name' => $center->getName(),
                'address' => $center->getAddress()->getAddress(),
                'community' => $center->getAddress()->getCommunity(),
                'province' => $center->getAddress()->getProvince(),
                'city   ' => $center->getAddress()->getCity(),
                'id' => $center->getId()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }

    
}
