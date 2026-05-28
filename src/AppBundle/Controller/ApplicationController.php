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
        $user = $this->getUser();
        $space = $application->getSpace();
        $isAdmin = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');

        // Vérifier que l'utilisateur est le propriétaire de l'espace ou un admin
        if (!$space->isOwner($user) && !$isAdmin) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à voir cette candidature.');
        }

        $prevApplication = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->getPrevApplication($application);
        $nextApplication = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->getNextApplication($application);

        $em = $this->get('doctrine.orm.entity_manager');

        // Marquer comme "en attente" uniquement si la candidature n'a pas encore été vue.
        // Condition alignée sur le contrôle d'accès ci-dessus (proprio OU admin).
        // Évite d'écraser ACCEPT/REJECT et évite un UPDATE inutile si déjà WAIT.
        if (($space->isOwner($user) || $isAdmin)
            && $application->getStatus() === Application::UNREAD_STATUS
        ) {
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
