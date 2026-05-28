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
use Symfony\Component\Security\Core\Exception\AuthenticationException;
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
        $isAdmin = $user && $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        $canView = $user && ($space->isOwner($user) || $isAdmin);

        // Espace non publié ou fermé : seuls le propriétaire et l'admin peuvent le voir
        if ((!$space->isEnabled() || $space->isClosed()) && !$canView) {
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
        $application = false;
        $em = $this->get('doctrine.orm.entity_manager');
        $userManager = $this->get('fos_user.user_manager');
        $connect_after_application = false;

        // Si l'utilisateur est connecté
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
            
            // Vérifier si le profil est complet pour les utilisateurs connectés
            if (!$user->isProfileComplete()) {
                $missing = method_exists($user, 'getMissingProfileFields') ? $user->getMissingProfileFields() : [];
                if (!empty($missing)) {
                    $this->addFlash(
                        'warning',
                        sprintf(
                            'Veuillez compléter votre profil avant de pouvoir candidater. Champs manquants : %s.',
                            implode(', ', $missing)
                        )
                    );
                } else {
                    $this->addFlash('warning', 'Veuillez compléter votre profil avant de pouvoir candidater.');
                }

                $next = $this->generateUrl('space_apply', ['space' => $space->getId()]);
                // Le champ "Zone(s) géographique(s) souhaitée(s)" est dans la section #two du profil (UX).
                $profilUrl = $this->generateUrl('security_profil', ['next' => $next]) . '#two';

                return $this->redirect($profilUrl);
            }
        } else {
            $user = $userManager->createUser();
            $user->setEnabled(true);
            $connect_after_application = true;
        }

        // Permettre l'accès même si l'espace est dépublié, mais pas s'il est fermé définitivement
        if ($space->isClosed()) {
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
            // Créer une nouvelle candidature avec les données du profil utilisateur
            $application = Application::createFromUser($user);
            $application->setSpace($space);
            
            // Si l'utilisateur est nouveau (pas connecté), le persister d'abord
            if ($user->getId() === null) {
                $userManager->updateUser($user);
                $userManager->updatePassword($user);
            }
            
            // IMPORTANT:
            // Ne pas persister une candidature à l'ouverture de la page.
            // La candidature est créée en base uniquement quand l'utilisateur clique sur
            // "Enregistrer en brouillon" ou "Soumettre".
        } elseif ($application->getStatus() === Application::UNREAD_STATUS) {
            // Pour l'instant on empeche les gens de refaire une candidature
            return $this->redirectToRoute('my_application_show', ['id' => $application->getId()]);
        }
        
        // Si la candidature existe déjà, s'assurer qu'elle a les données du profil utilisateur à jour
        // mais seulement pour les champs qui ne sont pas déjà remplis
        if ($application->getId() !== null) {
            $this->updateApplicationFromUserProfile($application, $user);
        }

        $form = $this->createForm(ApplicationType::class, $application, [
            'action' => $this->generateUrl('space_apply', ['space' => $space->getId()]),
            'user' => $user,
            // Sections profil affichées en récap (non éditables) dans apply:
            // on désactive ces champs pour éviter que Symfony ne vide le profil lors du POST.
            'freeze_profile_sections' => true,
        ]);

        // Debug: vérifier si le champ save existe
        if (!$form->has('save')) {
            // Ajouter le champ save manuellement si il n'existe pas
            $form->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Enregistrer en brouillon',
                'attr' => array('class' => 'btn btn-default-color submit_form')
            ));
        }

        // Vérifier les erreurs d'upload PHP avant de traiter le formulaire
        if ($request->isMethod('POST')) {
            $uploadErrors = [];
            $files = $request->files->all();
            
            foreach ($files as $key => $fileArray) {
                if (is_array($fileArray)) {
                    foreach ($fileArray as $subKey => $file) {
                        if ($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                            $errorCode = $file->getError();
                            if ($errorCode !== UPLOAD_ERR_OK) {
                                $errorMessage = $this->getUploadErrorMessage($errorCode, $file->getClientOriginalName());
                                if ($errorMessage) {
                                    $uploadErrors[] = $errorMessage;
                                }
                            }
                        }
                    }
                } elseif ($fileArray instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                    $errorCode = $fileArray->getError();
                    if ($errorCode !== UPLOAD_ERR_OK) {
                        $errorMessage = $this->getUploadErrorMessage($errorCode, $fileArray->getClientOriginalName());
                        if ($errorMessage) {
                            $uploadErrors[] = $errorMessage;
                        }
                    }
                }
            }
            
            // Ajouter les erreurs d'upload au formulaire
            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $errorMsg) {
                    $form->addError(new \Symfony\Component\Form\FormError($errorMsg));
                }
            }
        }

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
            $intent = '';
            $formData = $request->request->get($form->getName(), []);
            if (is_array($formData) && isset($formData['intent'])) {
                $intent = (string) $formData['intent'];
            }
            $isSaveIntent = $form->get('save')->isClicked() || $intent === 'save';
            $isSubmitIntent = $form->get('submit')->isClicked() || $intent === 'submit';
            
            // Vérifier l'état de l'espace seulement pour la soumission définitive
            if ($isSubmitIntent && (!$space->isEnabled() || $space->isClosed())) {
                if ($space->isClosed()) {
                    // Espace fermé définitivement
                    $this->addFlash('error', 'Cet espace a été fermé définitivement. Votre candidature ne peut pas être soumise.');
                    return $this->redirectToRoute('space_show', ['id' => $space->getId()]);
                } else {
                    // Espace temporairement suspendu - forcer l'enregistrement en brouillon
                    $this->addFlash('warning', 'Cet espace a été temporairement suspendu pour modification. Votre candidature a été sauvegardée en brouillon. Vous pourrez la compléter et la soumettre une fois l\'espace republié.');
                    $application->setStatus(Application::DRAFT_STATUS);
                    
                    // S'assurer que l'utilisateur est persisté avant l'application
                    if ($user->getId() === null) {
                        $userManager->updateUser($user);
                        $userManager->updatePassword($user);
                    } else {
                        $userManager->updateUser($user);
                    }
                    
                    $em->persist($application);
                    $em->persist($user);
                    $em->flush();
                    
                    return $this->redirectToRoute('my_applications_list');
                }
            }
            
            if ($isSubmitIntent) {
                $application->setStatus(Application::UNREAD_STATUS);
            } elseif ($isSaveIntent) {
                $application->setStatus(Application::DRAFT_STATUS);
            }

            // La "surface souhaitée" est désormais un champ de candidature (Application.wishedSize)
            // et ne doit pas être écrasée depuis le profil.

            // S'assurer que l'utilisateur est persisté avant l'application
            if ($user->getId() === null) {
                $userManager->updateUser($user);
                $userManager->updatePassword($user);
            } else {
                $userManager->updateUser($user);
            }

            $em->persist($application);
            $em->persist($user);
            $em->flush();

            try {
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
            } catch (\Exception $e) {
                $this->get('logger')->error('Échec envoi email confirmation candidature', ['exception' => $e, 'application_id' => $application->getId()]);
            }



            if ($connect_after_application) {
                $checker = $this->get('security.user_checker');
                try {
                    $checker->checkPreAuth($user);
                    $checker->checkPostAuth($user);
                } catch (AuthenticationException $e) {
                    $this->get('logger')->warning('Auto-login bloqué après candidature anonyme', ['user_id' => $user->getId(), 'reason' => $e->getMessage()]);
                    $checker = null;
                }
                if ($checker !== null) {
                    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                    $this->get('security.token_storage')->setToken($token);
                    $this->get('session')->migrate();
                    $this->get('session')->set('_security_main', serialize($token));
                    $event = new InteractiveLoginEvent($request, $token);
                    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
                }
            }

            if($application->getStatus() == Application::DRAFT_STATUS){
                return $this->redirectToRoute('my_applications_list');
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
     * Retourne un message d'erreur lisible pour les codes d'erreur PHP d'upload
     * 
     * @param int $errorCode Code d'erreur PHP (UPLOAD_ERR_*)
     * @param string $fileName Nom du fichier
     * @return string|null Message d'erreur ou null si pas d'erreur
     */
    private function getUploadErrorMessage($errorCode, $fileName)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                $maxSize = ini_get('upload_max_filesize');
                return sprintf('Le fichier "%s" dépasse la taille maximale autorisée par le serveur (%s). Veuillez choisir un fichier plus petit.', $fileName, $maxSize);
            
            case UPLOAD_ERR_FORM_SIZE:
                return sprintf('Le fichier "%s" dépasse la taille maximale autorisée (10 Mo). Veuillez choisir un fichier plus petit.', $fileName);
            
            case UPLOAD_ERR_PARTIAL:
                return sprintf('Le fichier "%s" n\'a été que partiellement téléchargé. Veuillez réessayer.', $fileName);
            
            case UPLOAD_ERR_NO_FILE:
                return null; // Pas de fichier, ce n'est pas une erreur si le champ n'est pas obligatoire
            
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Erreur serveur : répertoire temporaire manquant. Veuillez contacter l\'administrateur.';
            
            case UPLOAD_ERR_CANT_WRITE:
                return 'Erreur serveur : impossible d\'écrire le fichier sur le disque. Veuillez contacter l\'administrateur.';
            
            case UPLOAD_ERR_EXTENSION:
                return sprintf('Le fichier "%s" a été bloqué par une extension PHP. Veuillez contacter l\'administrateur.', $fileName);
            
            default:
                return sprintf('Erreur inconnue lors du téléchargement du fichier "%s". Veuillez réessayer.', $fileName);
        }
    }
    
    /**
     * Met à jour une candidature avec les données du profil utilisateur
     * mais seulement pour les champs qui ne sont pas déjà remplis
     */
    private function updateApplicationFromUserProfile($application, $user)
    {
        // Mettre à jour seulement les champs vides avec les données du profil
        if (empty($application->getDescription()) && !empty($user->getProjectDescription())) {
            $application->setDescription($user->getProjectDescription());
        }
        
        if (empty($application->getLengthOccupation()) && !empty($user->getUsageDuration())) {
            $application->setLengthOccupation($user->getUsageDuration());
        }
        
        if (empty($application->getLengthTypeOccupation()) && !empty($user->getLengthTypeOccupation())) {
            $application->setLengthTypeOccupation($user->getLengthTypeOccupation());
        }
        
        if (empty($application->getWishedSize()) && !empty($user->getWishedSize())) {
            $application->setWishedSize($user->getWishedSize());
        }
    }

    /**
     * @Route("/file/{id}/delete", name="space_removefile", requirements={"id": "\d+"})
     *
     * @param int     $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeFileAction($id, Request $request)
    {
        if (!$this->isCsrfTokenValid('remove_file_' . $id, $request->get('_token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $applicationFile = $em->getRepository('AppBundle:ApplicationFile')->find($id);
        if (!$applicationFile) {
            throw $this->createNotFoundException('Fichier non trouvé.');
        }

        $application = $applicationFile->getApplication();
        $currentUser = $this->getUser();
        if (!$currentUser || $application->getProjectHolder() !== $currentUser) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à supprimer ce fichier.');
        }

        $em->remove($applicationFile);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Le document a été supprimé.');

        $serviceUrl = $request->get('service');
        if ($serviceUrl && strpos($serviceUrl, '/') === 0 && strpos($serviceUrl, '//') !== 0) {
            return $this->redirect($serviceUrl);
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
            'available' => $space->isEnabled() && !$space->isClosed(),
            'closed' => $space->isClosed(),
        ]);

        return $response;
    }
}

