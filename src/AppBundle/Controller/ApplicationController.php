<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Entity\Space;
use AppBundle\Entity\User;
use AppBundle\Form\ApplicationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Application controller.
 *
 * @Route("/candidatures")
 **/
class ApplicationController extends Controller
{
    /**
     * @Route("/", name="application_list")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $applications = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->getApplicationPerOwner($user);

        return array(
            'applications' => $applications
        );
    }

    /**
     * @Route("/voir/{id}", name="application_show")
     * @Template()
     */
    public function showAction(Application $application)
    {
        return array(
            'application' => $application
        );
    }
}
