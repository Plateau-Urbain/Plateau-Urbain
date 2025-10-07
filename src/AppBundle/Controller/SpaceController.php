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

        if ( (!$space->isEnabled() && ($user === null || (!$space->isOwner($user) && ! in_array("ROLE_ADMIN", $this->getUser()->getRoles()))))
          || ($space->isClosed() && ($user === null || (!$space->isOwner($user) && ! in_array("ROLE_ADMIN", $this->getUser()->getRoles())))) ) {
              return $this->redirect($this->generateUrl('search_index'));
          }

        if ($user === null) {
            return ['space' => $space];
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
        error_log('=== DEBUG APPLY ACTION APPELÉE ===');
        error_log('Espace ID: ' . $space->getId());
        error_log('Méthode HTTP: ' . $request->getMethod());
        error_log('URL: ' . $request->getUri());
        
        $application = false;
        $em = $this->get('doctrine.orm.entity_manager');
        $userManager = $this->get('fos_user.user_manager');
        $connect_after_application = false;

        // Si l'utilisateur est connecté
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
            
            // Vérifier si le profil est complet pour les utilisateurs connectés
            if (!$user->isProfileComplete()) {
                $this->addFlash('warning', 'Veuillez compléter votre profil avant de pouvoir candidater.');
                return $this->redirect($this->generateUrl('security_profil', [
                    'next' => $this->generateUrl('space_apply', ['space' => $space->getId()])
                ]));
            }
        } else {
            $user = $userManager->createUser();
            $user->setEnabled(true);
            $connect_after_application = true;
        }

        if (! $space->isEnabled() || $space->isClosed()) {
            return $this->redirect($this->generateUrl('search_index'));
        }

        if ($user->getId() && ($space->isOwner($user) || $user->isProprio())) {
            return $this->redirect($this->generateUrl('search_index'));
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

        // Debug: vérifier si le champ save existe
        if (!$form->has('save')) {
            // Ajouter le champ save manuellement si il n'existe pas
            $form->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Enregistrer en brouillon',
                'attr' => array('class' => 'btn btn-default-color submit_form')
            ));
        }

        $form->handleRequest($request);

        // Debug: vérifier l'état du formulaire
        if ($form->isSubmitted()) {
            error_log('=== DEBUG FORMULAIRE SOUMIS ===');
            error_log('Formulaire soumis: ' . ($form->isSubmitted() ? 'OUI' : 'NON'));
            error_log('Formulaire valide: ' . ($form->isValid() ? 'OUI' : 'NON'));
            error_log('Bouton submit cliqué: ' . ($form->get('submit')->isClicked() ? 'OUI' : 'NON'));
            error_log('Bouton save cliqué: ' . ($form->get('save')->isClicked() ? 'OUI' : 'NON'));
            
            // Debug des erreurs de validation
            if (!$form->isValid()) {
                error_log('=== ERREURS DE VALIDATION ===');
                foreach ($form->getErrors(true) as $error) {
                    error_log('Erreur: ' . $error->getMessage() . ' (champ: ' . $error->getOrigin()->getName() . ')');
                }
            }
            
            error_log('Données POST: ' . print_r($request->request->all(), true));
        }

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
            // Vérifier à nouveau l'état de l'espace avant de traiter la candidature
            if (!$space->isEnabled() || $space->isClosed()) {
                $this->addFlash('warning', 'Cet espace n\'est plus disponible pour les candidatures. Votre candidature a été sauvegardée en brouillon.');
                $application->setStatus(Application::DRAFT_STATUS);
                $em->persist($application);
                $em->flush();
                
                return $this->redirectToRoute('space_show', ['id' => $space->getId()]);
            }
            
            if ($form->get('submit')->isClicked()) {
                error_log('✅ Statut défini: UNREAD_STATUS (soumission)');
                $application->setStatus(Application::UNREAD_STATUS);
            } elseif ($form->get('save')->isClicked()) {
                error_log('✅ Statut défini: DRAFT_STATUS (brouillon)');
                $application->setStatus(Application::DRAFT_STATUS);
            } else {
                error_log('❌ Aucun bouton détecté comme cliqué');
            }

            $userManager->updateUser($user);

            if ($user->getId() === null) {
                $userManager->updatePassword($user);
            }

            $em->persist($application);
            $em->persist($user);
            $em->flush();

	    $message = (new \Swift_Message())
            	    ->setSubject('Confirmation de candidature')
                    ->setFrom($this->container->getParameter('mail_confirmation_from'))
                    ->setTo($application->getProjectHolder()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'AppBundle:Email:candidacy_confirmation.html.twig',
                            array(
                                'space' => $space
                            )
                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);



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

        if ($request->get('service')) {
            return $this->redirect($request->get('service'));
        }

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

    /**
     * Vérifier l'état d'un espace (pour AJAX)
     * 
     * @Route("/check-status/{id}", name="space_check_status")
     */
    public function checkStatusAction(Space $space)
    {
        $response = new \Symfony\Component\HttpFoundation\JsonResponse([
            'enabled' => $space->isEnabled(),
            'closed' => $space->isClosed(),
            'submitted' => $space->isSubmitted(),
            'available' => $space->isEnabled() && !$space->isClosed()
        ]);

        return $response;
    }
}

