<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AACController
 * @package AppBundle\Controller
 * @Route("/appels-a-candidature")
 */
class AACController extends Controller
{
    /**
     * @Route("/list", name="aac_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $filters = [
            'sort_field' => 'created',
            'sort_order' => 'DESC',
            'status_filter' => null
        ];

        $params = [
            'enabled' => true
        ];

        $query = $this->getDoctrine()->getManager()
                                     ->getRepository('AppBundle:Space')->filter($params);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );

        return [
            'pagination' => $pagination
        ];
    }

    /**
     * @Route("/show")
     */
    public function showAction()
    {
        return $this->render('AppBundle:AAC:show.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/validate")
     */
    public function validateAction()
    {
        return $this->render('AppBundle:AAC:validate.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/reject")
     */
    public function rejectAction()
    {
        return $this->render('AppBundle:AAC:reject.html.twig', array(
            // ...
        ));
    }

}
