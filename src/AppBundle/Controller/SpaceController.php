<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Space;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Space controller.
 *
 * @Route("/spaces")
 **/
class SpaceController extends Controller
{
    /**
     * @Route("/", name="space_list")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space');
        $spaces = $em->findAll();

        return compact('spaces');
    }

    /**
     * @Route("/show/{id}", name="space_show")
     * @Template()
     */
    public function showAction(Space $space)
    {
        return compact('space');
    }
}
