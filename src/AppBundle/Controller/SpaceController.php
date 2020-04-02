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
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

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
     * @param Request $request La requête
     * @Template()
     */
    public function applyAction(Space $space, Request $request)
    {
        $application = false;
        $em = $this->get('doctrine.orm.entity_manager');
        $userManager = $this->get('fos_user.user_manager');
        $connect_after_application = false;

        // Si l'utilisateur est connecté
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = $userManager->createUser();
            $user->setEnabled(true);
            $connect_after_application = true;
        }

        if (! $space->isEnabled() || $space->isClosed()) {
            throw new AccessDeniedException("L'espace est inacessible");
        }

        if ($user->getId() && ($space->isOwner($user) || $user->isProprio())) {
            throw new AccessDeniedException("Vous n'avez pas le droit de candidater");
        }

        $application = $em->getRepository(Application::class)->findOneBy([
            'projectHolder' => $user->getId(),
            'space' => $space->getId()
        ]);

        if (! $application instanceof Application) {
            $application = Application::createFromUser($user);
            $application->setSpace($space);
        } elseif ($application->getStatus() === Application::UNREAD_STATUS) {
            // Pour l'instant on empeche les gens de refaire une candidature
            return $this->redirectToRoute('my_application_show', ['id' => $application->getId()]);
        }

        $form = $this->createForm(ApplicationType::class, $application, [
            'action' => $this->generateUrl('space_apply', ['space' => $space->getId()]),
            'user' => $user
        ]);

        $form->handleRequest($request);

        // On vérifie qu'un compte n'existe pas avec la même adresse email
        if ($form->isSubmitted() && $user->getId() === null) {
            $exists = $userManager->findUserByEmail($form->get('projectHolder')->get('userInfo')->getData()->getEmail());

            if ($exists) {
                $this->addFlash('error_sign', 'Cette adresse email est déjà utilisée.');
                $url = $this->container->get('router')->generate("homepage");
                $response = new RedirectResponse($url);
                return $response;
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $application->setStatus(Application::UNREAD_STATUS);
            }

            $userManager->updateUser($user);

            if ($user->getId() === null) {
                $userManager->updatePassword($user);
            }

            $em->persist($application);
            $em->persist($user);
            $em->flush();

            if ($connect_after_application) {
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->migrate();
                $this->get('session')->set('_security_main', serialize($token));
                $event = new InteractiveLoginEvent($request, $token);
                $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
            }

            if($application->getStatus() == Application::DRAFT_STATUS){
                return $this->redirectToRoute('space_show', [
                    'id' => $space->getId().'#espace_sauvegarde'
                ]);
            } else {
                return $this->redirectToRoute('my_application_show', [
                    'id' => $application->getId()
                ]);
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
