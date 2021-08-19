<?php
// vim:expandtab:sw=4 softtabstop=4:

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
    private $availableCodes = array('95', '78', '92', '93', '75', '94', '77', '91');

    /**
     * @Route("/", name="search_index")
     * @Template()
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $form = $this->createForm(SearchType::class);

        $params = array(
            'orderBy'           => 'created',
            'sort'              => 'DESC',
            'limitAvailability' => new \DateTime('today'),
            'enabled'           => true,
            'closed'            => false,
        );

        $all = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space')->filter($params);

        $departements = $this->buildDepartementsFromSpaces($all);

        return array(
            'form'         => $form->createView(),
            'latest'       => $all,
            'departements' => $departements,
        );
    }

    /**
     * @Route("/resultats", name="search_action", methods={"POST"})
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $search = $this->createForm(SearchType::class);
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
                'limitAvailability' => new \DateTime('today'),
                'enabled'           => true,
                'closed'            => false,
            );

            $query = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space')->filter($params);

            unset($params['zipCode']);
            $departementsSpace = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space')->filter($params);
            $departements = $this->buildDepartementsFromSpaces($departementsSpace);

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),/*page number*/
                10
            );

            return array(
                'zipCode'       => $search->get('zipCode')->getData(),
                'pagination'    => $pagination,
                'form'          => $search->createView(),
                'departements'  => $departements
            );
        }
    }

    /**
     * @param $spaces
     * @return mixed
     */
    private function buildDepartementsFromSpaces($spaces) {
        $departements = array();

        foreach ($spaces as $space) {
            if (in_array($space->getDepCode(), $this->availableCodes)) {
                if (!isset($departements[$space->getDepCode()])) {
                    $departements[$space->getDepCode()] = 0;
                }

                $departements[$space->getDepCode()] += 1;
            }
        }

        return $departements;
    }
}
