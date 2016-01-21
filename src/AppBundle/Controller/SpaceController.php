<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Entity\Space;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Space controller.
 *
 * @Route("/espaces")
 **/
class SpaceController extends Controller
{
    /**
     * @Route("/", name="space_list")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Space');
        $spaces = $repository->findAllEnabled();

        return array(
            'spaces' => $spaces
        );
    }

    /**
     * @Route("/fiche/{id}", name="space_show", methods={"get", "post"})
     * @Template()
     */
    public function showAction(Space $space, Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        if (!$space->isEnabled() && !$space->isOwner($user)
            || $space->isClosed() && !$space->isOwner($user)
        ) {
            throw new AccessDeniedException();
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $application = $em->getRepository('AppBundle:Application')->findOneBy(
            array(
                'projectHolder' => $user->getId(),
                'space' => $space->getId()
            )
        );

        if (!$application instanceof Application) {
            $application = Application::createFromUser($user);
            $application->setSpace($space);
        }

        $form = $this->createForm('appbundle_application', $application, array(
            'action' => $this->generateUrl(
                'space_show',
                array(
                    'id' => $space->getId()
                )
            ),
            'attr' => array(
                'novalidate' => true
            )
        ));

        if ($form->handleRequest($request)->isValid()) {
            $application->setStatus(Application::UNREAD_STATUS);

            $em->persist($application);
            $em->flush();

            return new RedirectResponse(
                $this->generateUrl(
                    'space_show',
                    array(
                        'id' => $space->getId()
                    )
                ) . "#espace_confirmation"
            );
        }

        // Check if the profile is completed
        $errors = $this->container->get('validator')->validate($user, array('default', 'projectHolder'));
        $invalidProfile = (count($errors) > 0) ? true : false;

        return array(
            'space'          => $space,
            'form'           => $form->createView(),
            'invalidProfile' => $invalidProfile,
            'application'    => $application
        );
    }

    /**
     * @Route("/confirmation", name="space_confirmation")
     * @Template()
     */
    public function  confirmationAction()
    {
        return array();
    }
}
