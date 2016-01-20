<?php

namespace AppBundle\Controller;

use AppBundle\Form\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchController
 * @package AppBundle\Controller
 * @Route("/recherche")
 */
class SearchController extends Controller
{
    /**
     * @Route("/", name="search_index")
     * @Template()
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $form = $this->createForm(new SearchType());

        $params = array(
            'orderBy'           => 'created',
            'sort'              => 'DESC',
            'limitAvailability' => new \DateTime('now'),
            'enabled'           => true,
            'closed'            => false,
        );

        $all = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space')->filter($params);

        foreach ($all as $space) {
            if (!isset($departements[$space->getDepCode()])) {
                $departements[$space->getDepCode()] = 0;
            }

            $departements[$space->getDepCode()] += 1;
        }

        return array(
            'form'         => $form->createView(),
            'latest'       => array_slice($all, 0, 6),
            'departements' => $departements,
        );
    }
    /**
     * @Route("/resultats", name="search_action")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $search = $this->createForm(new SearchType());
        $search->handleRequest($request);

        if ($search->isValid())
        {
            $params = array(
                'zipCode'           => $search->get('zipCode')->getData(),
                'localType'         => $search->get('localType')->getData(),
                'minimumPrice'      => $search->get('minimumPrice')->getData(),
                'maximumPrice'      => $search->get('maximumPrice')->getData(),
                'minimumSurface'    => $search->get('minimumSurface')->getData(),
                'maximumSurface'    => $search->get('maximumSurface')->getData(),
                'orderBy'           => $search->get('orderBy')->getData(),
                'sort'              => $search->get('sort')->getData(),
                'limitAvailability' => new \DateTime('now'),
                'enabled'           => true,
                'closed'            => false,
            );

            $query = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space')->filter($params);

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),/*page number*/
                10
            );

            return array("pagination" => $pagination, "form" => $search->createView());
        }
    }
}