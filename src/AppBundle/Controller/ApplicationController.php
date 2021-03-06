<?php
// vim:expandtab:sw=4 softtabstop=4:
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
	// see https://symfony.com/blog/new-in-symfony-2-6-security-component-improvements
        $user = $this->get('security.token_storage')->getToken()->getUser();
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
        $prevApplication = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->getPrevApplication($application);
        $nextApplication = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->getNextApplication($application);

        $em = $this->get('doctrine.orm.entity_manager');

        if ($this->getUser()->isProprio()) {
            $application->setStatus(Application::WAIT_STATUS);

            $em->persist($application);
            $em->flush();
        }

        return array(
            'prevApplication'   => $prevApplication,
            'nextApplication'   => $nextApplication,
            'application'       => $application
        );
    }
}
