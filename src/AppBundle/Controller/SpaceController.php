<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApplicationFile;
use AppBundle\Entity\Application;
use AppBundle\Entity\Space;
use AppBundle\Entity\User;
use AppBundle\Form\ApplicationType;
use AppBundle\Form\ProjectOwnerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Space controller.
 *
 * @Route("/espaces")
 **/
class SpaceController extends Controller
{
    /**
     * Fiche d'un espace
     *
     * @Route("/fiche/{id}", name="space_show", methods={"get", "post"})
     * @Template()
     */
    public function showAction(Space $space, Request $request)
    {
        $user = $this->getUser();
        $em = $this->get('doctrine.orm.entity_manager');

        if ($user === null) {
            if ($space->isClosed() || ! $space->isEnabled()) {
                throw new AccessDeniedException();
            }
            return ['space' => $space];
        }

        if (!$space->isEnabled() && !$space->isOwner($user)
            || $space->isClosed() && !$space->isOwner($user)
        ) {
            throw new AccessDeniedException();
        }

        $application = $em->getRepository(Application::class)->findOneBy(
            array(
                'projectHolder' => $user->getId(),
                'space' => $space->getId()
            )
        );

        return array(
            'space'          => $space,
            'application'    => $application
        );
    }

    /**
     * Formulaire de candidature d'un espace.
     * Nécessite d'être connecté
     *
     * @Route("/fiche/{space}/apply", name="space_apply")
     *
     * @param Space $space L'objet espace dont l'ID corresponds dans l'URL
     * @param UserPasswordEncoderInterface $encoder Le hasheur de mot de passe
     * @param Request $request La requête
     * @Template()
     */
    public function applyAction(Space $space, UserPasswordEncoderInterface $encoder, Request $request)
    {
        $logged = false;
        $user = false;
        $application = false;
        $em = $this->get('doctrine.orm.entity_manager');

        // Si l'utilisateur est connecté
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $logged = true;
            $user = $this->getUser();
        }

        if (! $space->isEnabled() || $space->isClosed()) {
            throw new AccessDeniedException("L'espace est inacessible");
        }

        if ($user && ($space->isOwner($user) || $user->isProprio())) {
            throw new AccessDeniedException("Vous n'avez pas le droit de candidater");
        }

        if ($logged === true) {
            $application = $em->getRepository(Application::class)->findOneBy([
                'projectHolder' => $user->getId(),
                'space' => $space->getId()
            ]);
        }

        if (! $application instanceof Application) {
            $application = ($logged === false) ? new Application()
                                               : Application::createFromUser($user);
            $application->setSpace($space);
        }

        $form = $this->createForm(
            ApplicationType::class,
            $application,
            ['action' => $this->generateUrl('space_apply', ['space' => $space->getId()])]
        );

        if ($form->handleRequest($request)->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $application->setStatus(Application::UNREAD_STATUS);
            }

            $newUser = $form->get('projectHolder')->getData();
            $encoded_password = $encoder->encodePassword($newUser, $newUser->getPassword());
            $newUser->setPassword($encoded_password);

            $em->persist($application);
            $em->persist($newUser);
            $em->flush();

            if($application->getStatus() == Application::DRAFT_STATUS){
                return new RedirectResponse(
                    $this->generateUrl(
                        'space_show',
                        array(
                            'id' => $space->getId()
                        )
                    ) . "#espace_sauvegarde"
                );
            } else {
                return new RedirectResponse(
                    $this->generateUrl(
                        'space_show',
                        array(
                            'id' => $space->getId()
                        )
                    ) . "#espace_confirmation"
                );
            }
        }

        return [
            'application' => $application,
            'space' => $space,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/file/{id}/delete", name="space_removefile")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeFileAction(ApplicationFile $applicationFile, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->remove($applicationFile);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Le document a été supprimé.');

        return $this->redirect(
          $this->generateUrl('space_show', array( 'id' => $applicationFile->getApplication()->getSpace()->getId()))
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
