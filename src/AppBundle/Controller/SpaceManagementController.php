<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Entity\Parcel;
use AppBundle\Entity\Space;
use AppBundle\Entity\SpaceImage;
use AppBundle\Entity\SpaceDocument;
use AppBundle\Entity\SpaceVisit;
use AppBundle\Form\SpaceType;
use Sonata\Exporter\Handler;
use Sonata\Exporter\Source\DoctrineORMQuerySourceIterator;
use Sonata\Exporter\Writer\CsvWriter;
use ZipArchive;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Space controller.
 *
 * @Route("/espace-manager")
 **/
class SpaceManagementController extends Controller
{
    /**
     * @Route("/", name="space_manager_list")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // see https://symfony.com/blog/new-in-symfony-2-6-security-component-improvements
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $isAdmin = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');

        // Handle the filter form
        $filterForm = $this->handleSpaceFilterForm($request, array(
            'sort_field' => 'created',
            'sort_order' => 'desc',
            'status_filter' => null
        ));

        $filters = $filterForm->getData();

        $params = array(
            'orderBy'   => $filters['sort_field'],
            'sort'      => $filters['sort_order']
        );

        // Si admin, voir tous les espaces. Sinon, seulement ceux de l'utilisateur
        if ($isAdmin) {
            // Pour les admins, on peut ajouter un filtre pour voir les espaces en attente
            if ($filters['status_filter'] == 'pending') {
                $params['submitted'] = true;
                $params['enabled'] = false;
            } else if ($filters['status_filter'] == 'closed') {
                $params['closed'] = true;
            } else if ($filters['status_filter'] == 'enabled')  {
                $params['enabled'] = true;
            }
        } else {
            // Pour les propriétaires, seulement leurs espaces
            $params['user'] = $user;
            
            if ($filters['status_filter'] == 'closed') {
                $params['closed'] = true;
            } else if ($filters['status_filter'] == 'enabled')  {
                $params['enabled'] = true;
            }
        }

        $query = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space')->filter($params);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/
        );

        return array(
            "pagination" => $pagination,
            'filterForm' => $filterForm->createView(),
            'isAdmin' => $isAdmin
        );
    }

    /**
     * @param Space $space
     *
     * @return Response
     *
     * @Route("/previsualiser/{id}", name="space_manager_preview", methods={"get"})
     * @Template()
     */
    public function previewAction(Request $request, Space $space)
    {
        return $this->forward('AppBundle:Space:show', array('space' => $space));
    }

    /**
     * @Route("/ajouter", name="space_manager_add", methods={"get", "post"})
     * @Template()
     */
    public function addAction(Request $request)
    {
        $space = new Space();
        $space->setOwner($this->getUser());
        $space->setClosed(false);
        $limitAvailability = (new \DateTime('today'))->modify('+1 month');
        $limitAvailability->setTime(23, 59, 59);
        $space->setLimitAvailability($limitAvailability);

        $form = $this->createSpaceForm($space, array(
            'action' => $this->generateUrl('space_manager_add'),
            'method' => 'post'
        ));

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            $em->persist($space);

            if ($form->get('publish')->isClicked()) {
                return $this->submitSpace($space);
            }

            $em->flush();

            if ($form->get('preview')->isClicked()) {
                return $this->redirect($this->generateUrl('space_manager_preview', array('id' => $space->getId())));
            }

            $this->get('session')->getFlashBag()->set('success', 'L\'espace a été enregistré.');

            // Default is edition
            return $this->redirect($this->generateUrl('space_manager_edit', array('id' => $space->getId())));
        }

        return array('form' => $form->createView(), 'space' => $space);
    }

    /**
     * @param Space $space
     *
     * @return Response
     *
     * @Route("/editer/{id}", name="space_manager_edit", methods={"get", "put"})
     * @Template()
     */
    public function editAction(Request $request, Space $space)
    {
        $isAdmin = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        
        // Check ownership - Les admins peuvent modifier n'importe quel espace
        if (!$space->isOwner($this->getUser()) && !$isAdmin) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à modifier cet espace.');
        }
        
        // Les propriétaires ne peuvent pas modifier un espace qui est soumis mais pas encore publié
        // Seuls les admins peuvent modifier les espaces en attente de validation
        if (!$isAdmin && $space->isSubmitted() && !$space->isEnabled()) {
            throw new AccessDeniedException('Cet espace est en attente de validation par un administrateur. Vous ne pouvez pas le modifier pour le moment.');
        }

        $form = $this->createSpaceForm($space, array(
            'action' => $this->generateUrl('space_manager_edit', array('id' => $space->getId())),
            'method' => 'put'
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('publish')->isClicked()) {
                return $this->submitSpace($space);
            }

            if ($form->get('preview')->isClicked()) {
                $response = new Response($this->generateUrl('space_manager_preview', array('id' => $space->getId())), 200);
                $response->headers->set('Content-Type', 'text/plain');
                return $response;
            }

            $this->get('doctrine.orm.entity_manager')->flush();
            $this->get('session')->getFlashBag()->set('success', 'L\'espace a été enregistré.');

            // Default is edition
            return $this->redirect($this->generateUrl('space_manager_edit', array('id' => $space->getId())));
        }

        return array(
            'form' => $form->createView(),
            'space' => $space
        );
    }

    /**
     * @Route("/close/{id}", name="space_manager_close", methods={"POST"})
     */
    public function closeAction(Space $space, Request $request)
    {
        if (!$this->isCsrfTokenValid('space_close_' . $space->getId(), $request->request->get('_token'))) {
            throw new AccessDeniedException('Token CSRF invalide.');
        }
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à clôturer cet espace.');
        }

        $space->setClosed(true);

        $em = $this->getDoctrine()->getManager();

        $em->persist($space);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Espace fermé');

        return $this->redirect($this->generateUrl('space_manager_list'));
    }


    /**
     * Dépublier un appel à candidatures
     *
     * @Route("/depublier/{id}", name="space_manager_unpublish", methods={"POST"})
     */
    public function unpublishAction(Space $space, Request $request)
    {
        if (!$this->isCsrfTokenValid('space_unpublish_' . $space->getId(), $request->request->get('_token'))) {
            throw new AccessDeniedException('Token CSRF invalide.');
        }
        // Vérifier que l'utilisateur est propriétaire de l'espace OU admin
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à dépublier cet espace.');
        }

        // Vérifier que l'espace est bien activé (enabled)
        if (!$space->isEnabled()) {
            $this->get('session')->getFlashBag()->set('error', 'Cet espace n\'est pas activé.');
            return $this->redirect($this->generateUrl('space_manager_list'));
        }

        // Vérifier s'il y a des candidatures en cours
        $nbApplications = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Application')
            ->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.space = :space')
            ->andWhere('a.status != :draft')
            ->setParameter('space', $space)
            ->setParameter('draft', 'draft')
            ->getQuery()
            ->getSingleScalarResult();

        // Si candidatures existent, permettre mais avec avertissement
        if ($nbApplications > 0) {
            $this->get('session')->getFlashBag()->set('warning', 
                'Attention : Cet espace a été dépublié temporairement alors qu\'il avait ' . $nbApplications . ' candidature(s). ' .
                'Les candidats ne peuvent plus voir l\'annonce. Pensez à republier rapidement après vos corrections.');
        }

        // Dépublier l'espace
        $space->setEnabled(false);
        // Optionnellement, remettre submitted à false pour permettre les modifications
        $space->setSubmitted(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($space);
        $em->flush();

        if ($nbApplications > 0) {
            $this->get('session')->getFlashBag()->set('success', 'Espace dépublié temporairement. Modifiez-le rapidement et republiez-le pour que les candidats puissent le voir à nouveau.');
        } else {
            $this->get('session')->getFlashBag()->set('success', 'Espace dépublié avec succès. Vous pouvez maintenant le modifier.');
        }

        return $this->redirect($this->generateUrl('space_manager_list'));
    }

    /**
     * Publier un espace en attente de validation (Admin uniquement)
     *
     * @Route("/publier/{id}", name="space_manager_publish", methods={"POST"})
     */
    public function publishAction(Space $space, Request $request)
    {
        if (!$this->isCsrfTokenValid('space_publish_' . $space->getId(), $request->request->get('_token'))) {
            throw new AccessDeniedException('Token CSRF invalide.');
        }
        // Seuls les admins peuvent publier directement un espace
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Seuls les administrateurs peuvent publier des espaces.');
        }

        // Vérifier que l'espace est soumis mais pas encore activé
        if (!$space->isSubmitted() || $space->isEnabled()) {
            $this->get('session')->getFlashBag()->set('error', 'Cet espace ne peut pas être publié.');
            return $this->redirect($this->generateUrl('space_manager_list'));
        }

        // Activer l'espace
        $space->setEnabled(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($space);
        $em->flush();

        // Envoyer un email de confirmation au propriétaire
        try {
            $message = (new \Swift_Message())
                ->setSubject('Votre espace a été publié sur Plateau Urbain')
                ->setFrom($this->container->getParameter('mail_confirmation_from'))
                ->setTo($space->getOwner()->getEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:Email:space_published.html.twig',
                        compact('space')
                    ), 'text/html'
                );

            $this->get('mailer')->send($message);
        } catch (\Exception $e) {
            $this->get('logger')->error('Échec envoi email publication espace au propriétaire', ['exception' => $e, 'space_id' => $space->getId()]);
        }

        // Notifier les candidats qui ont des brouillons
        $draftApplications = $em->getRepository('AppBundle:Application')
            ->findBy([
                'space' => $space,
                'status' => 'draft'
            ]);

        foreach ($draftApplications as $application) {
            try {
                $notificationMessage = (new \Swift_Message())
                    ->setSubject('Espace à nouveau disponible !')
                    ->setFrom($this->container->getParameter('mail_confirmation_from'))
                    ->setTo($application->getProjectHolder()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'AppBundle:Email:space_available_again.html.twig',
                            [
                                'space' => $space,
                                'application' => $application
                            ]
                        ), 'text/html'
                    );

                $this->get('mailer')->send($notificationMessage);
            } catch (\Exception $e) {
                $this->get('logger')->error('Échec envoi email brouillon candidat (espace publié)', ['exception' => $e, 'application_id' => $application->getId()]);
            }
        }

        $this->get('session')->getFlashBag()->set('success', 'L\'espace "' . $space->getName() . '" a été publié avec succès. Le propriétaire a été notifié par email.');

        return $this->redirect($this->generateUrl('space_manager_list'));
    }

    /**
     * @Route("/candidats/{id}", name="space_manager_candidates", methods={"get", "post"}, requirements={"id": "\d+"})
     * @Template()
     */
    public function candidatesAction(Request $request, Space $space)
    {
        // Vérifier que l'utilisateur est bien propriétaire de l'espace ou admin
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à voir les candidatures de cet espace.');
        }

        if ($request->isMethod('post')) {
            if (!$this->isCsrfTokenValid('candidates_action', $request->get('_token'))) {
                throw $this->createAccessDeniedException('Token CSRF invalide.');
            }

            $em = $this->getDoctrine()->getManager();

            $ids = $request->get('applications');
            $messageText = $request->get('message');
            $action = $request->get('action');

            $ids = explode('-', $ids);
            foreach ($ids as $id) {

                $application = $em->getRepository('AppBundle:Application')->findOneBy(array(
                    'id' => $id,
                    'space' => $space->getId()
                ));

                if (!$application || (!$application->isAwaiting() && !$application->isUnread())) {
                    continue;
                }

                if ($action == 'accept') {
                    $application->setStatus(Application::ACCEPT_STATUS);
                } elseif ($action == 'refuse') {
                    $application->setStatus(Application::REJECT_STATUS);
                }

                try {
                    $message = (new \Swift_Message())
                        ->setSubject($action == 'accept' ? 'Candidature Acceptée' : 'Candidature rejetée')
                        ->setFrom($this->container->getParameter('mail_confirmation_from'))
                        ->setTo($application->getProjectHolder()->getEmail())
                        ->setBody(
                            $this->renderView(
                                'AppBundle:Email:candidate.html.twig',
                                array(
                                    'space'      => $space,
                                    'message'    => $messageText,
                                    'user'       => $application->getProjectHolder(),
                                    'isAccepted' => $application->isAccepted()
                                )
                            ),
                            'text/html'
                        );

                    $this->get('mailer')->send($message);
                } catch (\Exception $e) {
                    $this->get('logger')->error('Échec envoi email acceptation/refus candidature', ['exception' => $e, 'application_id' => $application->getId()]);
                }
            }

            $em->flush();

            return $this->redirect(
                $this->generateUrl('space_manager_candidates', array('id' => $space->getId()))
            );
        }

        // Handle the filter form
        $filterForm = $this->handleFilterForm($request, array(
            'sort_field' => 'created',
            'sort_order' => 'desc',
            'status_filter' => null
        ));

        $filters = $filterForm->getData();
        
        // Sauvegarder les filtres en session pour l'export personnalisé
        $session = $request->getSession();
        $session->set('space_' . $space->getId() . '_filters', $filters);

        $params = array(
            'space'     => $space,
            'orderBy'   => $filters['sort_field'],
            'status'    => $filters['status_filter'],
            'selected'  => $filters['status_filter'],
            'sort'      => $filters['sort_order']
        );

        $query = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->filter($params);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            25
        );

        $em = $this->getDoctrine()->getManager();

        // Pour les graphiques, on affiche :
        //  - tous les items actifs (isActive = true)
        //  - plus les items archivés qui ont au moins une candidature sur CET espace
        // Cela garde l'historique utile sans polluer l'affichage avec des items
        // archivés qui n'ont jamais servi ici.
        $usedCategoryIds = $em->createQuery(
            'SELECT DISTINCT IDENTITY(a.category) FROM AppBundle:Application a WHERE a.space = :space AND a.category IS NOT NULL'
        )->setParameter('space', $space)->getResult();
        $usedCategoryIds = array_map(function ($row) {
            return is_array($row) ? reset($row) : $row;
        }, $usedCategoryIds);

        $categoriesQb = $em->getRepository('AppBundle:Category')->createQueryBuilder('c')
            ->where('c.isActive = :active')
            ->setParameter('active', true);
        if (!empty($usedCategoryIds)) {
            $categoriesQb->orWhere('c.id IN (:ids)')->setParameter('ids', $usedCategoryIds);
        }
        $categories = $categoriesQb->orderBy('c.name', 'ASC')->getQuery()->getResult();

        $usedUseTypeIds = $em->createQuery(
            'SELECT DISTINCT IDENTITY(u.useType)
             FROM AppBundle:Application a
             JOIN a.projectHolder u
             WHERE a.space = :space AND u.useType IS NOT NULL'
        )->setParameter('space', $space)->getResult();
        $usedUseTypeIds = array_map(function ($row) {
            return is_array($row) ? reset($row) : $row;
        }, $usedUseTypeIds);

        $useTypesQb = $em->getRepository('AppBundle:UseType')->createQueryBuilder('u')
            ->where('u.isActive = :active')
            ->setParameter('active', true);
        if (!empty($usedUseTypeIds)) {
            $useTypesQb->orWhere('u.id IN (:ids)')->setParameter('ids', $usedUseTypeIds);
        }
        $useTypes = $useTypesQb->orderBy('u.name', 'ASC')->getQuery()->getResult();

        return array(
            'space'         => $space,
            'pagination'    => $pagination,
            'useTypes'      => $useTypes,
            'categories'    => $categories,
            'filterForm'    => $filterForm->createView()
        );
    }

    /**
     * @param Request $request
     * @param Space   $space
     *
     * @return Response
     *
     * @Route("/candidats/{id}/export", name="space_manager_candidatesexport", methods={"get"}, requirements={"id": "\d+"})
     */
    public function candidatesExportAction(Request $request, Space $space)
    {
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à exporter les candidatures de cet espace.');
        }

        // Handle the filter form
        $filterForm = $this->handleFilterForm($request, array(
            'sort_field' => 'created',
            'sort_order' => 'desc',
            'status_filter' => null
        ));

        $filters = $filterForm->getData();

        $params = array(
            'space'     => $space,
            'orderBy'   => $filters['sort_field'],
            'status'    => $filters['status_filter'],
            'sort'      => $filters['sort_order']
        );

        $qb = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->filter($params);

        $sourceIterator = new DoctrineORMQuerySourceIterator(
            $qb->getQuery(),
            array(
                'Espace' => 'space',
                'Statut' => 'statusLabel',
                'Nom' => 'name',
                'Structure' => 'projectHolder.company',
                'Nom du porteur' => 'projectHolder.fullName',
                'Téléphone personnel' => 'projectHolder.phone',
                'Téléphone structure' => 'projectHolder.companyPhone',
                'Email' => 'projectHolder.email',
                'Départements souhaités' => 'projectHolder.preferredDepartmentsLabelsForExport',
                'Présentation' => 'projectHolder.companyDescription',
                'Facebook' => 'projectHolder.facebookUrl',
                'Twitter' => 'projectHolder.twitterUrl',
                'Instagram' => 'projectHolder.instagramUrl',
                'Google+' => 'projectHolder.googleUrl',
                'Linkedin' => 'projectHolder.linkedinUrl',
                'Autre' => 'projectHolder.otherUrl',
                'Présentation du projet' => 'description',
                'Quel sera l\'usage du local ?' => 'localUsageDescription',
                'Date de dépôt de la candidature' => 'created',
                'Type d\'usage' => 'category',
                'Statut juridique (profil)' => 'projectHolder.companyStatus',
                'Statut juridique (candidature)' => 'companyStatus',
                'Surface souhaitée (profil)' => 'projectHolder.wishedSize',
                'Surface souhaitée (candidature)' => 'wishedSize',
                'Budget mensuel total maximum (€)' => 'projectHolder.monthlyBudgetMax',
                'Date d\'entrée souhaitée' => 'startOccupation',
                'Quelles idées avez-vous pour participer au projet collectif ?' => 'contribution'
            ),
            'd/m/Y'
        );

        $writer = new CsvWriter('php://output');
        $filename = 'export_candidatures.csv';

        $callback = function () use ($sourceIterator, $writer) {
            Handler::create($sourceIterator, $writer)->export();
        };

        return new StreamedResponse($callback, 200, array(
            'Content-Type' => 'application/csv',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
        ));
    }

    /**
     * @Route("/candidates-select-export-fields/{id}", name="space_manager_select_export_fields", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Space $space
     *
     * @return Response
     */
    public function selectExportFieldsForSpaceAction(Request $request, Space $space)
    {
        // Vérifier les permissions
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à exporter les candidatures de cet espace.');
        }

        // Récupérer tous les champs disponibles
        $availableFields = $this->getAllAvailableFieldsForExport();
        
        // Récupérer les filtres depuis la session
        $session = $request->getSession();
        $filterData = $session->get('space_' . $space->getId() . '_filters', [
            'status_filter' => null,
            'sort_field' => 'created',
            'sort_order' => 'desc'
        ]);
        
        // Si le formulaire est soumis
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('export_fields', $request->request->get('_token'))) {
                throw $this->createAccessDeniedException('Token CSRF invalide.');
            }

            $selectedFields = $request->request->get('fields', []);
            $includeDocuments = $request->request->get('include_documents') === '1';
            $includeApplicationFiles = $request->request->get('include_application_files') === '1';
            $includeUserDocuments = $request->request->get('include_user_documents') === '1';
            
            if (empty($selectedFields)) {
                $this->addFlash('error', 'Veuillez sélectionner au moins un champ à exporter.');
                return $this->render('AppBundle:SpaceManagement:select_export_fields.html.twig', [
                    'space' => $space,
                    'availableFields' => $availableFields,
                    'filterData' => $filterData,
                ]);
            }
            
            // Sauvegarder les champs sélectionnés en session
            $session->set('space_' . $space->getId() . '_selected_fields', $selectedFields);
            // Sauvegarder les options de documents
            $session->set('space_' . $space->getId() . '_include_documents', $includeDocuments);
            $session->set('space_' . $space->getId() . '_include_application_files', $includeApplicationFiles);
            $session->set('space_' . $space->getId() . '_include_user_documents', $includeUserDocuments);
            
            // Rediriger vers l'export personnalisé
            return $this->redirectToRoute('space_manager_custom_export', ['id' => $space->getId()]);
        }
        
        return $this->render('AppBundle:SpaceManagement:select_export_fields.html.twig', [
            'space' => $space,
            'availableFields' => $availableFields,
            'filterData' => $filterData,
        ]);
    }

    /**
     * @Route("/candidates-custom-export/{id}", name="space_manager_custom_export", methods={"GET"})
     *
     * @param Request $request
     * @param Space $space
     *
     * @return Response
     */
    public function customCandidatesExportAction(Request $request, Space $space)
    {
        // Vérifier les permissions
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à exporter les candidatures de cet espace.');
        }

        $session = $request->getSession();
        
        // Récupérer les champs sélectionnés depuis la session
        $selectedFieldKeys = $session->get('space_' . $space->getId() . '_selected_fields', []);
        
        if (empty($selectedFieldKeys)) {
            $this->addFlash('error', 'Aucun champ sélectionné pour l\'export.');
            return $this->redirectToRoute('space_manager_candidates', ['id' => $space->getId()]);
        }
        
        // Récupérer tous les champs disponibles
        $allFields = $this->getAllAvailableFieldsForExport();
        
        // Construire le tableau des champs à exporter
        $exportFields = [];
        foreach ($selectedFieldKeys as $key) {
            if (isset($allFields[$key])) {
                $exportFields[$allFields[$key]['label']] = $allFields[$key]['property'];
            }
        }
        
        // Récupérer les filtres depuis la session
        $filterData = $session->get('space_' . $space->getId() . '_filters', [
            'status_filter' => null,
            'sort_field' => 'created',
            'sort_order' => 'desc'
        ]);
        
        // Construire les paramètres de filtrage
        $params = array(
            'space'     => $space,
            'orderBy'   => $filterData['sort_field'],
            'status'    => $filterData['status_filter'],
            'sort'      => $filterData['sort_order']
        );
        
        // Récupérer les candidatures filtrées
        $qb = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->filter($params);
        
        // Récupérer les options de documents
        $includeDocuments = $session->get('space_' . $space->getId() . '_include_documents', false);
        $includeApplicationFiles = $session->get('space_' . $space->getId() . '_include_application_files', true);
        $includeUserDocuments = $session->get('space_' . $space->getId() . '_include_user_documents', true);
        
        // Nettoyer la session après la récupération
        $session->remove('space_' . $space->getId() . '_selected_fields');
        $session->remove('space_' . $space->getId() . '_include_documents');
        $session->remove('space_' . $space->getId() . '_include_application_files');
        $session->remove('space_' . $space->getId() . '_include_user_documents');
        
        if ($includeDocuments) {
            // Ajouter les joins pour plus d'efficacité et éviter les problèmes de lazy loading
            $qb->leftJoin('a.files', 'f')
               ->addSelect('f')
               ->leftJoin('a.projectHolder', 'u')
               ->addSelect('u')
               ->leftJoin('u.documents', 'ud')
               ->addSelect('ud');
            
            $applications = $qb->getQuery()->getResult();
            
            // Créer le ZIP
            $zip = new ZipArchive();
            $tempFile = tempnam(sys_get_temp_dir(), 'export_custom_');
            $zip->open($tempFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            
            $csvRows = [];
            $headers = array_keys($exportFields);
            $csvRows[] = $headers;
            $xlsRows = [];
            
            $applicationFilesPath = realpath($this->get('kernel')->getRootDir() . '/../web/uploads/application_files') . '/';
            $userDocumentsPath = realpath($this->get('kernel')->getRootDir() . '/../web/uploads/user_documents') . '/';
            
            $filesAddedCount = 0;
            $appsProcessedCount = 0;

            foreach ($applications as $application) {
                $appsProcessedCount++;
                $candidateName = $this->sanitizeFileName($application->getProjectHolder()->getFullName());
                $companyName = $this->sanitizeFileName($application->getProjectHolder()->getCompany());
                $folderName = 'documents/' . $candidateName . '_' . ($companyName ?: 'sans_structure');
                $row = [];
                $xlsRow = [];
                // Génération des données CSV
                foreach ($exportFields as $label => $property) {
                    $value = $this->resolveExportValue($application, $property, $folderName);
                    $row[] = (string) $value;
                    $isProfileRequiredDocLink = in_array($property, [
                        'computed.profileRequiredIdDocPath',
                        'computed.profileRequiredKbisDocPath'
                    ], true) && !empty($value);
                    $xlsHtml = null;
                    if ($property === 'computed.applicationDocumentsPaths') {
                        $xlsHtml = $this->buildApplicationDocumentsLinksHtml($application, $folderName);
                    }
                    $xlsRow[] = [
                        'value' => (string) $value,
                        'link' => $isProfileRequiredDocLink,
                        'html' => $xlsHtml
                    ];
                }
                $csvRows[] = $row;
                $xlsRows[] = $xlsRow;

                // Ajouter le récapitulatif HTML (imprimable / PDF) dans le dossier du candidat
                $recapByCategory = [];
                foreach ($allFields as $field) {
                    $category = isset($field['category']) ? (string) $field['category'] : 'Autres';
                    $label = isset($field['label']) ? (string) $field['label'] : '';
                    $property = isset($field['property']) ? (string) $field['property'] : '';
                    if ($label === '' || $property === '') {
                        continue;
                    }
                    if ($property === 'projectHolder.civility') {
                        continue;
                    }
                    if ($property === 'projectHolder.companyBlog' || $property === 'projectHolder.description') {
                        continue;
                    }
                    $value = $this->resolveExportValue($application, $property, $folderName);
                    if (trim((string) $value) === '') {
                        continue;
                    }
                    if (!isset($recapByCategory[$category])) {
                        $recapByCategory[$category] = [];
                    }
                    $recapByCategory[$category][] = [
                        'label' => $label,
                        'value' => $value,
                    ];
                }
                $recapByCategory = array_filter($recapByCategory);
                $summaryContent = $this->renderView('AppBundle:SpaceManagement:application_summary.html.twig', [
                    'application' => $application,
                    'recapByCategory' => $recapByCategory,
                ]);
                $zip->addFromString($folderName . '/recapitulatif.html', $summaryContent);

                // Ajout des documents
                // Documents de candidature
                if ($includeApplicationFiles) {
                    foreach ($application->getFiles() as $file) {
                        if ($file->getFileName()) {
                            $filePath = $applicationFilesPath . $file->getFileName();
                            if (file_exists($filePath)) {
                                $displayName = $file->getFileName();
                                if ($file->getSpaceDocument()) {
                                    $displayName = $this->sanitizeFileName($file->getSpaceDocument()->getName()) . '_' . $file->getFileName();
                                }
                                if ($zip->addFile($filePath, $folderName . '/candidature/' . $displayName)) {
                                    $filesAddedCount++;
                                }
                            }
                        }
                    }
                }
                
                // Documents du profil
                if ($includeUserDocuments) {
                    foreach ($application->getProjectHolder()->getDocuments() as $userDoc) {
                        if ($userDoc->getFileName()) {
                            $filePath = $userDocumentsPath . $userDoc->getFileName();
                            if (file_exists($filePath)) {
                                $displayName = $userDoc->getFileName();
                                if ($userDoc->getType()) {
                                    $typeLabel = $this->getDocumentTypeLabel($userDoc->getType());
                                    $displayName = $this->sanitizeFileName($typeLabel) . '_' . $userDoc->getFileName();
                                }
                                if ($zip->addFile($filePath, $folderName . '/profil/' . $displayName)) {
                                    $filesAddedCount++;
                                }
                            }
                        }
                    }
                }
            }
            
            // Ajouter le CSV au ZIP
            $csvContent = '';
            foreach ($csvRows as $row) {
                $escapedRow = array_map(function($cell) {
                    return '"' . str_replace('"', '""', $cell) . '"';
                }, $row);
                $csvContent .= implode(';', $escapedRow) . "\r\n";
            }
            $csvFilename = sprintf('candidatures_%s_%s.csv', $this->sanitizeFileName($space->getName()), date('Y-m-d'));
            $zip->addFromString($csvFilename, "\xEF\xBB\xBF" . $csvContent);

            // Ajouter une version XLS (HTML compatible Excel) avec liens cliquables
            $xlsContent = $this->buildHtmlXlsContent($headers, $xlsRows);
            $xlsFilename = sprintf('candidatures_%s_%s.xls', $this->sanitizeFileName($space->getName()), date('Y-m-d'));
            $zip->addFromString($xlsFilename, $xlsContent);

            // Petit fichier de statut pour diagnostic
            $statusInfo = sprintf("Applications traitées: %d\nFichiers ajoutés: %d\nDate: %s", $appsProcessedCount, $filesAddedCount, date('Y-m-d H:i:s'));
            $zip->addFromString('status_export.txt', $statusInfo);
            
            $zip->close();
            
            $filename = sprintf('export_candidatures_%s_%s.zip', $this->sanitizeFileName($space->getName()), date('Y-m-d_H-i-s'));
            $response = new BinaryFileResponse($tempFile);
            $response->headers->set('Content-Type', 'application/zip');
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
            $response->deleteFileAfterSend(true);

            return $response;
        }
        
        // Export CSV simple
        $hasComputedFields = false;
        foreach ($exportFields as $property) {
            if (strpos($property, 'computed.') === 0) {
                $hasComputedFields = true;
                break;
            }
        }

        if ($hasComputedFields) {
            $applications = $qb->getQuery()->getResult();
            $headers = array_keys($exportFields);
            $callback = function () use ($applications, $exportFields, $headers) {
                echo "\xEF\xBB\xBF";
                $rows = [];
                $rows[] = $headers;
                foreach ($applications as $application) {
                    $candidateName = $this->sanitizeFileName($application->getProjectHolder()->getFullName());
                    $companyName = $this->sanitizeFileName($application->getProjectHolder()->getCompany());
                    $folderName = 'documents/' . $candidateName . '_' . ($companyName ?: 'sans_structure');
                    $row = [];
                    foreach ($exportFields as $property) {
                        $row[] = (string) $this->resolveExportValue($application, $property, $folderName);
                    }
                    $rows[] = $row;
                }
                foreach ($rows as $row) {
                    $escapedRow = array_map(function ($cell) {
                        return '"' . str_replace('"', '""', $cell) . '"';
                    }, $row);
                    echo implode(';', $escapedRow) . "\r\n";
                }
            };

            $filename = sprintf(
                'export_candidatures_%s_%s.csv',
                $this->sanitizeFileName($space->getName()),
                date('Y-m-d_H-i-s')
            );

            return new StreamedResponse($callback, 200, array(
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ));
        }

        // Créer l'export
        $sourceIterator = new DoctrineORMQuerySourceIterator(
            $qb->getQuery(),
            $exportFields,
            'd/m/Y H:i'
        );
        
        $writer = new CsvWriter('php://output');
        $filename = sprintf(
            'export_candidatures_%s_%s.csv',
            $this->sanitizeFileName($space->getName()),
            date('Y-m-d_H-i-s')
        );
        
        $callback = function () use ($sourceIterator, $writer) {
            Handler::create($sourceIterator, $writer)->export();
        };
        

        return new StreamedResponse($callback, 200, array(
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
        ));
    }

    /**
     * Retourne tous les champs disponibles pour l'export
     */
    private function getAllAvailableFieldsForExport()
    {
        return [
            // Informations générales
            'space' => [
                'label' => '[Candidature] Espace',
                'property' => 'space',
                'category' => 'Informations générales'
            ],
            'id' => [
                'label' => '[Candidature] ID de la candidature',
                'property' => 'id',
                'category' => 'Informations générales'
            ],
            'name' => [
                'label' => '[Candidature] Nom du projet',
                'property' => 'name',
                'category' => 'Informations générales'
            ],
            'status' => [
                'label' => '[Candidature] Statut',
                'property' => 'statusLabel',
                'category' => 'Informations générales'
            ],
            'selected' => [
                'label' => '[Candidature] Sélectionné',
                'property' => 'selected',
                'category' => 'Informations générales'
            ],
            'created' => [
                'label' => '[Candidature] Date de création',
                'property' => 'created',
                'category' => 'Informations générales'
            ],
            'updated' => [
                'label' => '[Candidature] Date de mise à jour',
                'property' => 'updated',
                'category' => 'Informations générales'
            ],
            
            // Profil - Porteur de projet
            'projectHolder_fullName' => [
                'label' => '[Profil] Nom complet du porteur',
                'property' => 'projectHolder.fullName',
                'category' => 'Profil - Porteur de projet'
            ],
            'projectHolder_email' => [
                'label' => '[Profil] Email du porteur',
                'property' => 'projectHolder.email',
                'category' => 'Profil - Porteur de projet'
            ],
            'projectHolder_civility' => [
                'label' => '[Profil] Civilité',
                'property' => 'projectHolder.civility',
                'category' => 'Profil - Porteur de projet'
            ],
            'projectHolder_birthday' => [
                'label' => '[Profil] Date de naissance',
                'property' => 'projectHolder.birthday',
                'category' => 'Profil - Porteur de projet'
            ],
            'projectHolder_newsletter' => [
                'label' => '[Profil] Newsletter',
                'property' => 'projectHolder.newsletter',
                'category' => 'Profil - Porteur de projet'
            ],
            'projectHolder_requiredIdDoc' => [
                'label' => '[Profil] Doc obligatoire - Pièce d\'identité (chemin local)',
                'property' => 'computed.profileRequiredIdDocPath',
                'category' => 'Profil - Documents obligatoires'
            ],
            'projectHolder_requiredKbisDoc' => [
                'label' => '[Profil] Doc obligatoire - Justificatif d\'activité (chemin local)',
                'property' => 'computed.profileRequiredKbisDocPath',
                'category' => 'Profil - Documents obligatoires'
            ],
            
            // Profil - Structure du porteur de projet
            'projectHolder_civility' => [
                'label' => '[Profil] Civilité',
                'property' => 'projectHolder.civility',
                'category' => 'Profil - Mes informations'
            ],
            'projectHolder_firstname' => [
                'label' => '[Profil] Prénom',
                'property' => 'projectHolder.firstname',
                'category' => 'Profil - Mes informations'
            ],
            'projectHolder_lastname' => [
                'label' => '[Profil] Nom',
                'property' => 'projectHolder.lastname',
                'category' => 'Profil - Mes informations'
            ],
            'projectHolder_birthday' => [
                'label' => '[Profil] Date de naissance',
                'property' => 'projectHolder.birthday',
                'category' => 'Profil - Mes informations'
            ],
            'projectHolder_email' => [
                'label' => '[Profil] Email',
                'property' => 'projectHolder.email',
                'category' => 'Profil - Mes informations'
            ],
            'projectHolder_phone' => [
                'label' => '[Profil] Téléphone personnel',
                'property' => 'projectHolder.phone',
                'category' => 'Profil - Mes informations'
            ],

            // Profil - Structure du porteur de projet
            'projectHolder_company' => [
                'label' => '[Profil] Nom de la structure',
                'property' => 'projectHolder.company',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_siret' => [
                'label' => '[Profil] SIRET',
                'property' => 'projectHolder.siret',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_companyStatus' => [
                'label' => '[Profil] Statut de la structure',
                'property' => 'projectHolder.companyStatus',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_companyCreationDate' => [
                'label' => '[Profil] Date de création de la structure',
                'property' => 'projectHolder.companyCreationDate',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_address' => [
                'label' => '[Profil] Adresse',
                'property' => 'projectHolder.address',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_zipcode' => [
                'label' => '[Profil] Code postal',
                'property' => 'projectHolder.zipcode',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_companyPhone' => [
                'label' => '[Profil] Téléphone structure',
                'property' => 'projectHolder.companyPhone',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_companyMobile' => [
                'label' => '[Profil] Mobile',
                'property' => 'projectHolder.companyMobile',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_companyEffective' => [
                'label' => '[Profil] Nombre de personnes',
                'property' => 'projectHolder.companyEffective',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_companyStructures' => [
                'label' => '[Profil] Structure d\'accompagnement',
                'property' => 'projectHolder.companyStructures',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_companySite' => [
                'label' => '[Profil] Site web',
                'property' => 'projectHolder.companySite',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            'projectHolder_companyDescription' => [
                'label' => '[Profil] Présentation de la structure',
                'property' => 'projectHolder.companyDescription',
                'category' => 'Profil - Structure du porteur de projet'
            ],
            
            // Profil - Réseaux sociaux
            'projectHolder_facebookUrl' => [
                'label' => '[Profil] Facebook',
                'property' => 'projectHolder.facebookUrl',
                'category' => 'Profil - Réseaux sociaux'
            ],
            'projectHolder_twitterUrl' => [
                'label' => '[Profil] Twitter',
                'property' => 'projectHolder.twitterUrl',
                'category' => 'Profil - Réseaux sociaux'
            ],
            'projectHolder_instagramUrl' => [
                'label' => '[Profil] Instagram',
                'property' => 'projectHolder.instagramUrl',
                'category' => 'Profil - Réseaux sociaux'
            ],
            'projectHolder_googleUrl' => [
                'label' => '[Profil] Google+',
                'property' => 'projectHolder.googleUrl',
                'category' => 'Profil - Réseaux sociaux'
            ],
            'projectHolder_linkedinUrl' => [
                'label' => '[Profil] LinkedIn',
                'property' => 'projectHolder.linkedinUrl',
                'category' => 'Profil - Réseaux sociaux'
            ],
            'projectHolder_youtubeUrl' => [
                'label' => '[Profil] YouTube',
                'property' => 'projectHolder.youtubeUrl',
                'category' => 'Profil - Réseaux sociaux'
            ],
            'projectHolder_tiktokUrl' => [
                'label' => '[Profil] TikTok',
                'property' => 'projectHolder.tiktokUrl',
                'category' => 'Profil - Réseaux sociaux'
            ],
            'projectHolder_otherUrl' => [
                'label' => '[Profil] Autre URL',
                'property' => 'projectHolder.otherUrl',
                'category' => 'Profil - Réseaux sociaux'
            ],
            
            // Profil - Mon projet
            'projectHolder_wishedSize' => [
                'label' => '[Profil] Surface souhaitée (m²)',
                'property' => 'projectHolder.wishedSize',
                'category' => 'Profil - Mon projet'
            ],
            'projectHolder_useType' => [
                'label' => '[Profil] Type de projet',
                'property' => 'projectHolder.useType',
                'category' => 'Profil - Mon projet'
            ],
            'projectHolder_preferredDepartments' => [
                'label' => '[Profil] Zone géographique',
                'property' => 'projectHolder.preferredDepartmentsLabelsForExport',
                'category' => 'Profil - Mon projet'
            ],
            'projectHolder_usageDate' => [
                'label' => '[Profil] Date de disponibilité',
                'property' => 'projectHolder.usageDate',
                'category' => 'Profil - Mon projet'
            ],
            'projectHolder_usageDuration' => [
                'label' => '[Profil] Durée d\'occupation',
                'property' => 'projectHolder.usageDuration',
                'category' => 'Profil - Mon projet'
            ],
            'projectHolder_monthlyBudgetMax' => [
                'label' => '[Profil] Budget mensuel total maximum (€)',
                'property' => 'projectHolder.monthlyBudgetMax',
                'category' => 'Profil - Mon projet'
            ],
            'projectHolder_projectDescription' => [
                'label' => '[Profil] Présentation du projet',
                'property' => 'projectHolder.projectDescription',
                'category' => 'Profil - Mon projet'
            ],

            // Candidature - Informations sur le projet
            'description' => [
                'label' => '[Candidature] Présentation du projet',
                'property' => 'description',
                'category' => 'Candidature - Informations sur le projet'
            ],
            'localUsageDescription' => [
                'label' => '[Candidature] Quel sera l\'usage du local ?',
                'property' => 'localUsageDescription',
                'category' => 'Candidature - Informations sur le projet'
            ],
            'category' => [
                'label' => '[Candidature] Type d\'usage',
                'property' => 'category',
                'category' => 'Candidature - Informations sur le projet'
            ],
            'companyStatus' => [
                'label' => '[Candidature] Statut juridique',
                'property' => 'companyStatus',
                'category' => 'Candidature - Informations sur le projet'
            ],
            'contribution' => [
                'label' => '[Candidature] Quelles idées avez-vous pour participer au projet collectif ?',
                'property' => 'contribution',
                'category' => 'Candidature - Informations sur le projet'
            ],
            'openToGlobalProject' => [
                'label' => '[Candidature] Ouvert au projet collectif',
                'property' => 'openToGlobalProject',
                'category' => 'Candidature - Informations sur le projet'
            ],
            
            // Candidature - Occupation
            'wishedSize' => [
                'label' => '[Candidature] Surface souhaitée (m²)',
                'property' => 'wishedSize',
                'category' => 'Candidature - Occupation'
            ],
            'startOccupation' => [
                'label' => '[Candidature] Date d\'entrée souhaitée',
                'property' => 'startOccupation',
                'category' => 'Candidature - Occupation'
            ],
            'application_documents_paths' => [
                'label' => '[Candidature] Documents déposés (chemins locaux)',
                'property' => 'computed.applicationDocumentsPaths',
                'category' => 'Candidature - Documents déposés'
            ],
        ];
    }

    /**
     * @Route("/candidates-export-zip/{id}", name="space_manager_candidatesexportzip", methods={"get"})
     *
     * @param Request $request
     * @param Space $space
     *
     * @return Response
     */
    public function candidatesExportZipAction(Request $request, Space $space)
    {
        // Vérifier les permissions
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à exporter les candidatures de cet espace.');
        }

        // Handle the filter form
        $filterForm = $this->handleFilterForm($request, array(
            'sort_field' => 'created',
            'sort_order' => 'desc',
            'status_filter' => null
        ));

        $filters = $filterForm->getData();

        $params = array(
            'space'     => $space,
            'orderBy'   => $filters['sort_field'],
            'status'    => $filters['status_filter'],
            'sort'      => $filters['sort_order']
        );

        $qb = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->filter($params);
        $applications = $qb->getQuery()->getResult();

        // Créer le fichier ZIP temporaire
        $zip = new ZipArchive();
        $tempFile = tempnam(sys_get_temp_dir(), 'export_candidatures_');
        $zip->open($tempFile, ZipArchive::CREATE);

        $applicationFilesPath = $this->get('kernel')->getRootDir() . '/../web/uploads/application_files/';
        $userDocumentsPath = $this->get('kernel')->getRootDir() . '/../web/uploads/user_documents/';

        foreach ($applications as $application) {
            // Créer le nom du dossier pour cette candidature
            $candidateName = $this->sanitizeFileName($application->getProjectHolder()->getFullName());
            $companyName = $this->sanitizeFileName($application->getProjectHolder()->getCompany());
            $folderName = $candidateName . '_' . $companyName;
            
            // Préparer les données du récapitulatif (mêmes champs que l'export personnalisé)
            $availableFields = $this->getAllAvailableFieldsForExport();
            $recapByCategory = [];
            foreach ($availableFields as $field) {
                $category = isset($field['category']) ? (string) $field['category'] : 'Autres';
                $label = isset($field['label']) ? (string) $field['label'] : '';
                $property = isset($field['property']) ? (string) $field['property'] : '';
                if ($label === '' || $property === '') {
                    continue;
                }
                if ($property === 'projectHolder.civility') {
                    continue;
                }
                if ($property === 'projectHolder.companyBlog' || $property === 'projectHolder.description') {
                    continue;
                }
                $value = $this->resolveExportValue($application, $property, $folderName);
                if (trim((string) $value) === '') {
                    continue;
                }
                if (!isset($recapByCategory[$category])) {
                    $recapByCategory[$category] = [];
                }
                $recapByCategory[$category][] = [
                    'label' => $label,
                    'value' => $value,
                ];
            }
            $recapByCategory = array_filter($recapByCategory);

            // Créer le récapitulatif HTML
            $summaryContent = $this->renderView('AppBundle:SpaceManagement:application_summary.html.twig', [
                'application' => $application,
                'recapByCategory' => $recapByCategory,
            ]);
            
            $zip->addFromString($folderName . '/recapitulatif.html', $summaryContent);

            // Ajouter les documents de la candidature (ApplicationFile)
            foreach ($application->getFiles() as $file) {
                if ($file->getFileName()) {
                    $filePath = $applicationFilesPath . $file->getFileName();
                    if (file_exists($filePath)) {
                        // Créer un nom de fichier plus descriptif
                        $displayName = $file->getFileName();
                        if ($file->getSpaceDocument()) {
                            $displayName = $file->getSpaceDocument()->getName() . '_' . $file->getFileName();
                        }
                        $zip->addFile($filePath, $folderName . '/documents_candidature/' . $displayName);
                    }
                }
            }

            // Ajouter les documents du profil utilisateur (UserDocument)
            foreach ($application->getProjectHolder()->getDocuments() as $userDoc) {
                if ($userDoc->getFileName()) {
                    $filePath = $userDocumentsPath . $userDoc->getFileName();
                    if (file_exists($filePath)) {
                        // Créer un nom de fichier plus descriptif
                        $displayName = $userDoc->getFileName();
                        if ($userDoc->getType()) {
                            $typeLabel = $this->getDocumentTypeLabel($userDoc->getType());
                            $displayName = $typeLabel . '_' . $userDoc->getFileName();
                        }
                        $zip->addFile($filePath, $folderName . '/documents_profil/' . $displayName);
                    }
                }
            }
        }

        $zip->close();

        // Générer le nom du fichier
        $filename = 'export_candidatures_' . $this->sanitizeFileName($space->getName()) . '_' . date('Y-m-d_H-i-s') . '.zip';

        // Retourner le fichier ZIP
        $response = new BinaryFileResponse($tempFile);
        $response->headers->set('Content-Type', 'application/zip');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
        $response->deleteFileAfterSend(true);

        return $response;
    }

    /**
     * @Route("/candidates-export-zip-selected/{id}", name="space_manager_candidatesexportzip_selected", methods={"post"})
     *
     * @param Request $request
     * @param Space $space
     *
     * @return Response
     */
    public function candidatesExportZipSelectedAction(Request $request, Space $space)
    {
        // Vérifier les permissions
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à exporter les candidatures de cet espace.');
        }

        // Vérifier le token CSRF
        if (!$this->isCsrfTokenValid('export_selected', $request->request->get('_token'))) {
            throw new BadRequestHttpException('Token CSRF invalide.');
        }

        // Récupérer les IDs des candidatures sélectionnées
        $selectedIds = $request->request->get('selected_applications', []);
        
        if (empty($selectedIds)) {
            throw new BadRequestHttpException('Aucune candidature sélectionnée.');
        }

        // Récupérer les candidatures sélectionnées
        $em = $this->getDoctrine()->getManager();
        $applications = $em->getRepository('AppBundle:Application')
            ->createQueryBuilder('a')
            ->leftJoin('a.files', 'f')
            ->leftJoin('a.projectHolder', 'u')
            ->leftJoin('a.space', 's')
            ->where('a.id IN (:ids)')
            ->andWhere('a.space = :space')
            ->setParameter('ids', $selectedIds)
            ->setParameter('space', $space)
            ->getQuery()
            ->getResult();

        if (empty($applications)) {
            throw new BadRequestHttpException('Aucune candidature valide trouvée.');
        }

        // Créer le fichier ZIP temporaire
        $zip = new ZipArchive();
        $tempFile = tempnam(sys_get_temp_dir(), 'export_candidatures_selected_');
        $zip->open($tempFile, ZipArchive::CREATE);

        $applicationFilesPath = $this->get('kernel')->getRootDir() . '/../web/uploads/application_files/';
        $userDocumentsPath = $this->get('kernel')->getRootDir() . '/../web/uploads/user_documents/';

        foreach ($applications as $application) {
            // Créer le nom du dossier pour cette candidature
            $candidateName = $this->sanitizeFileName($application->getProjectHolder()->getFullName());
            $companyName = $this->sanitizeFileName($application->getProjectHolder()->getCompany());
            $folderName = $candidateName . '_' . $companyName;
            
            // Préparer les données du récapitulatif (mêmes champs que l'export personnalisé)
            $availableFields = $this->getAllAvailableFieldsForExport();
            $recapByCategory = [];
            foreach ($availableFields as $field) {
                $category = isset($field['category']) ? (string) $field['category'] : 'Autres';
                $label = isset($field['label']) ? (string) $field['label'] : '';
                $property = isset($field['property']) ? (string) $field['property'] : '';
                if ($label === '' || $property === '') {
                    continue;
                }
                if ($property === 'projectHolder.civility') {
                    continue;
                }
                if ($property === 'projectHolder.companyBlog' || $property === 'projectHolder.description') {
                    continue;
                }
                $value = $this->resolveExportValue($application, $property, $folderName);
                if (trim((string) $value) === '') {
                    continue;
                }
                if (!isset($recapByCategory[$category])) {
                    $recapByCategory[$category] = [];
                }
                $recapByCategory[$category][] = [
                    'label' => $label,
                    'value' => $value,
                ];
            }
            $recapByCategory = array_filter($recapByCategory);

            // Créer le récapitulatif HTML
            $summaryContent = $this->renderView('AppBundle:SpaceManagement:application_summary.html.twig', [
                'application' => $application,
                'recapByCategory' => $recapByCategory,
            ]);
            
            $zip->addFromString($folderName . '/recapitulatif.html', $summaryContent);

            // Ajouter les documents de la candidature (ApplicationFile)
            foreach ($application->getFiles() as $file) {
                if ($file->getFileName()) {
                    $filePath = $applicationFilesPath . $file->getFileName();
                    if (file_exists($filePath)) {
                        // Créer un nom de fichier plus descriptif
                        $displayName = $file->getFileName();
                        if ($file->getSpaceDocument()) {
                            $displayName = $file->getSpaceDocument()->getName() . '_' . $file->getFileName();
                        }
                        $zip->addFile($filePath, $folderName . '/documents_candidature/' . $displayName);
                    }
                }
            }

            // Ajouter les documents du profil utilisateur (UserDocument) - si disponibles
            if (method_exists($application->getProjectHolder(), 'getDocuments')) {
                foreach ($application->getProjectHolder()->getDocuments() as $userDoc) {
                    if ($userDoc->getFileName()) {
                        $filePath = $userDocumentsPath . $userDoc->getFileName();
                        if (file_exists($filePath)) {
                            // Créer un nom de fichier plus descriptif
                            $displayName = $userDoc->getFileName();
                            if ($userDoc->getType()) {
                                $typeLabel = $this->getDocumentTypeLabel($userDoc->getType());
                                $displayName = $typeLabel . '_' . $userDoc->getFileName();
                            }
                            $zip->addFile($filePath, $folderName . '/documents_profil/' . $displayName);
                        }
                    }
                }
            }
        }

        $zip->close();

        // Générer le nom du fichier
        $filename = 'export_candidatures_selection_' . $this->sanitizeFileName($space->getName()) . '_' . date('Y-m-d_H-i-s') . '.zip';

        // Retourner le fichier ZIP
        $response = new BinaryFileResponse($tempFile);
        $response->headers->set('Content-Type', 'application/zip');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
        $response->deleteFileAfterSend(true);

        return $response;
    }

    /**
     * Nettoie un nom de fichier pour qu'il soit valide, tout en préservant l'extension
     *
     * @param string $fileName
     * @return string
     */
    private function sanitizeFileName($fileName)
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $basename = pathinfo($fileName, PATHINFO_FILENAME);

        // Nettoyer le nom de base
        $basename = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $basename);
        $basename = preg_replace('/_+/', '_', $basename);
        $basename = trim($basename, '_');
        
        // Nettoyer l'extension si elle existe
        if ($extension) {
            $extension = preg_replace('/[^a-zA-Z0-9]/', '', $extension);
            // Recombiner avec la limite de longueur (255 max pour la plupart des FS)
            $result = substr($basename, 0, 250 - strlen($extension)) . '.' . $extension;
        } else {
            $result = substr($basename, 0, 255);
        }

        return $result ?: 'fichier_inconnu';
    }

    /**
     * Résout la valeur d'un champ export, y compris les champs calculés.
     *
     * @param Application $application
     * @param string      $property
     * @param string      $folderName
     *
     * @return string
     */
    private function resolveExportValue(Application $application, $property, $folderName = '')
    {
        if (strpos($property, 'computed.') === 0) {
            return $this->resolveComputedExportValue($application, $property, $folderName);
        }

        $parts = explode('.', $property);
        $value = $application;
        foreach ($parts as $part) {
            $getter = 'get' . ucfirst($part);
            if (is_object($value)) {
                if (method_exists($value, $getter)) {
                    $value = $value->$getter();
                } elseif (method_exists($value, $part)) {
                    $value = $value->$part();
                } else {
                    $value = '';
                    break;
                }
            } else {
                $value = '';
                break;
            }
        }

        if ($value instanceof \DateTime) {
            $value = $value->format('d/m/Y H:i');
        }
        if (is_array($value)) {
            $value = implode('; ', array_map('strval', $value));
        }

        return (string) $value;
    }

    /**
     * Résout les champs export calculés liés aux documents profil.
     *
     * @param Application $application
     * @param string      $property
     * @param string      $folderName
     *
     * @return string
     */
    private function resolveComputedExportValue(Application $application, $property, $folderName = '')
    {
        if ($property === 'computed.applicationDocumentsPaths') {
            $paths = $this->getApplicationDocumentRelativePaths($application, $folderName);
            return $paths ? implode('; ', $paths) : '';
        }

        $projectHolder = $application->getProjectHolder();
        if (!$projectHolder) {
            return '';
        }

        if ($property === 'computed.profileRequiredIdDocPath') {
            $docs = $projectHolder->getDocumentsType('id');
            if (!empty($docs) && $docs[0]->getFileName()) {
                $displayName = 'Piece_identite_' . $docs[0]->getFileName();
                return $folderName ? ($folderName . '/profil/' . $displayName) : $displayName;
            }
            return '';
        }

        if ($property === 'computed.profileRequiredKbisDocPath') {
            $docs = $projectHolder->getDocumentsType('kbis');
            if (!empty($docs) && $docs[0]->getFileName()) {
                $displayName = 'KBIS_' . $docs[0]->getFileName();
                return $folderName ? ($folderName . '/profil/' . $displayName) : $displayName;
            }
            return '';
        }

        return '';
    }

    /**
     * Chemins relatifs des fichiers de candidature (même convention que le ZIP).
     *
     * @param Application $application
     * @param string      $folderName
     *
     * @return string[]
     */
    private function getApplicationDocumentRelativePaths(Application $application, $folderName)
    {
        if ($folderName === '') {
            return array();
        }

        $paths = array();
        foreach ($application->getFiles() as $file) {
            if (!$file->getFileName()) {
                continue;
            }
            $displayName = $file->getFileName();
            if ($file->getSpaceDocument()) {
                $displayName = $this->sanitizeFileName($file->getSpaceDocument()->getName()) . '_' . $file->getFileName();
            }
            $paths[] = $folderName . '/candidature/' . $displayName;
        }

        return $paths;
    }

    /**
     * Liens HTML cliquables (un par document de candidature) pour export XLS.
     *
     * @param Application $application
     * @param string      $folderName
     *
     * @return string
     */
    private function buildApplicationDocumentsLinksHtml(Application $application, $folderName)
    {
        $paths = $this->getApplicationDocumentRelativePaths($application, $folderName);
        if (!$paths) {
            return '';
        }

        $parts = array();
        foreach ($paths as $relativePath) {
            $safeHref = htmlspecialchars($relativePath, ENT_QUOTES, 'UTF-8');
            $label = basename($relativePath);
            $safeLabel = htmlspecialchars($label ?: $relativePath, ENT_QUOTES, 'UTF-8');
            $parts[] = '<a href="' . $safeHref . '">' . $safeLabel . '</a>';
        }

        return implode('<br/>', $parts);
    }

    /**
     * Construit un contenu HTML compatible XLS avec liens cliquables.
     *
     * @param array $headers
     * @param array $rows
     *
     * @return string
     */
    private function buildHtmlXlsContent(array $headers, array $rows)
    {
        $html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
        $html .= '<style>table{border-collapse:collapse;}th,td{border:1px solid #ccc;padding:6px;vertical-align:top;}th{background:#f5f5f5;font-weight:bold;}</style>';
        $html .= '</head><body><table><tr>';

        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars((string) $header, ENT_QUOTES, 'UTF-8') . '</th>';
        }
        $html .= '</tr>';

        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $value = isset($cell['value']) ? (string) $cell['value'] : '';
                $cellHtml = isset($cell['html']) ? $cell['html'] : null;
                if ($cellHtml !== null && $cellHtml !== '') {
                    $html .= '<td>' . $cellHtml . '</td>';
                } else {
                    $isLink = !empty($cell['link']) && $value !== '';
                    if ($isLink) {
                        $safeHref = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                        $label = basename($value);
                        $safeLabel = htmlspecialchars($label ?: $value, ENT_QUOTES, 'UTF-8');
                        $html .= '<td><a href="' . $safeHref . '">' . $safeLabel . '</a></td>';
                    } else {
                        $html .= '<td>' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</td>';
                    }
                }
            }
            $html .= '</tr>';
        }

        $html .= '</table></body></html>';

        return $html;
    }

    /**
     * Retourne le label lisible pour un type de document
     *
     * @param string $type
     * @return string
     */
    private function getDocumentTypeLabel($type)
    {
        $labels = [
            'id' => 'Piece_identite',
            'kbis' => 'KBIS',
            '' => 'Autre_document'
        ];

        return isset($labels[$type]) ? $labels[$type] : 'Document_' . $type;
    }

    /**
     * @Route("/application/{id}/toggle_selected", name="space_manager_toggle_selected_application", methods={"get", "post"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function toggleSelectedApplication(Request $request, Application $application)
    {
        $space = $application->getSpace();
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à modifier cette candidature.');
        }

        if (!$this->isCsrfTokenValid('toggle_selected_' . $application->getId(), $request->get('_token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $application->setSelected(!$application->getSelected());

        $em->persist($application);
        $em->flush();

        $referer = $request->server->get('HTTP_REFERER');
        $host = $request->getHost();
        if ($referer && parse_url($referer, PHP_URL_HOST) === $host) {
            return $this->redirect($referer . "#listing-header");
        }

        return $this->redirect($this->generateUrl('space_manager_candidates', [
            'id' => $application->getSpace()->getId()
        ]) . "#listing-header");
    }

    /**
     * @Route("/photo/{id}/delete", name="space_manager_removepicture")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removePictureAction(Request $request, SpaceImage $image)
    {
        if (!$image->getSpace()->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à supprimer cette photo.');
        }

        // Check csrfToken
        if (!$this->isCsrfTokenValid('remove_image', $request->query->get('token'))) {
            throw new BadRequestHttpException('Invalid token');
        }

        $spaceId = $image->getSpace()->getId();

        $em = $this->get('doctrine.orm.entity_manager');
        $em->remove($image);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'La photo a été supprimée.');

        return $this->redirect($this->generateUrl('space_manager_edit', array('id' => $spaceId)));
    }

    /**
     * @Route("/photo/{id}/move/{position}", name="space_manager_movepicture", methods={"post"})
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function movePictureAction(Request $request, SpaceImage $image)
    {
        if (!$image->getSpace()->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à déplacer cette photo.');
        }

        // Check csrfToken
        if (!$this->isCsrfTokenValid('move_image', $request->query->get('token'))) {
            throw new BadRequestHttpException('Invalid token');
        }

        $spaceId = $image->getSpace()->getId();

        $position = (int) $request->get('position');
        $em = $this->get('doctrine.orm.entity_manager');
        $image->setPosition($position);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'La photo a été déplacée.');

        return $this->redirect($this->generateUrl('space_manager_edit', array('id' => $spaceId)));
    }

    /**
     * @Route("/supprimer/{id}", name="space_manager_delete", methods={"POST"})
     *
     * @param Space $space
     */
    public function removeAction(Space $space, Request $request)
    {
        if (!$this->isCsrfTokenValid('space_delete_' . $space->getId(), $request->request->get('_token'))) {
            throw new AccessDeniedException('Token CSRF invalide.');
        }
        if (!$space->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à supprimer cet espace.');
        }

        if ($space->isPublished()) {
            $this->get('session')->getFlashBag()->set('error', 'L\'espace n\'a pas été supprimé.');
            return $this->redirectToRoute('space_manager_list');
        }

        $em = $this->getDoctrine()->getManager();
        
        // Vérifier s'il y a des candidatures associées
        $applications = $em->getRepository('AppBundle:Application')->findBy(['space' => $space]);
        $nbApplications = count($applications);
        
        if ($nbApplications > 0) {
            // Supprimer d'abord toutes les candidatures associées
            foreach ($applications as $application) {
                // Supprimer les fichiers associés à la candidature
                $applicationFiles = $em->getRepository('AppBundle:ApplicationFile')->findBy(['application' => $application]);
                foreach ($applicationFiles as $file) {
                    $em->remove($file);
                }
                
                // Supprimer la candidature
                $em->remove($application);
            }
            
            $this->get('session')->getFlashBag()->set('warning', 
                'L\'espace a été supprimé avec ' . $nbApplications . ' candidature(s) associée(s).');
        }
        
        // Supprimer l'espace
        $em->remove($space);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'L\'espace a été supprimé.');

        return $this->redirectToRoute('space_manager_list');
    }

    /**
     * @Route("/document/{id}/delete", name="space_manager_removedocument", requirements={"id": "\d+"})
     *
     * @param int     $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeDocumentAction($id, Request $request)
    {
        if (!$this->isCsrfTokenValid('remove_document', $request->query->get('token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $spaceDocument = $em->getRepository('AppBundle:SpaceDocument')->find($id);
        if (!$spaceDocument) {
            throw $this->createNotFoundException('Document non trouvé.');
        }

        if (!$spaceDocument->getSpace()->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à supprimer ce document.');
        }

        $spaceId = $spaceDocument->getSpace()->getId();

        $em->remove($spaceDocument);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Le document a été supprimé.');

        return $this->redirect($this->generateUrl('space_manager_edit', array('id' => $spaceId)));
    }

    /**
     * @Route("/parcel/{id}/delete", name="space_manager_removeparcel")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeParcelAction(Request $request, Parcel $parcel)
    {
        if (!$parcel->getSpace()->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à supprimer ce lot.');
        }

        // Check csrfToken
        if (!$this->isCsrfTokenValid('remove_parcel', $request->query->get('token'))) {
            throw new BadRequestHttpException('Invalid token');
        }

        $spaceId = $parcel->getSpace()->getId();

        $em = $this->get('doctrine.orm.entity_manager');
        $em->remove($parcel);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Le lot a bien été supprimé.');

        return $this->redirect($this->generateUrl('space_manager_edit', array('id' => $spaceId)));
    }

    /**
     * @Route("/visit/{id}/delete", name="space_manager_removevisit")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeVisitAction(Request $request, SpaceVisit $visit)
    {
        if (!$visit->getSpace()->isOwner($this->getUser()) && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à supprimer cette visite.');
        }

        // Check csrfToken
        if (!$this->isCsrfTokenValid('remove_visit', $request->query->get('token'))) {
            throw new BadRequestHttpException('Invalid token');
        }

        $spaceId = $visit->getSpace()->getId();

        $em = $this->get('doctrine.orm.entity_manager');
        $em->remove($visit);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'La visite a bien été supprimée.');

        return $this->redirect($this->generateUrl('space_manager_edit', array('id' => $spaceId)));
    }

    /**
     * @param Space $data
     * @param array $options
     *
     * @return Form
     */
    protected function createSpaceForm($data, array $options = array())
    {
        $options['attr']['novalidate'] = true;

        //$form = $this->createForm('appbundle_space', $data, $options);
        $form = $this->createForm(SpaceType::class,
                                  $data, $options);

        $form->add('publish',
            'Symfony\Component\Form\Extension\Core\Type\SubmitType',
            //'submit',
            array(
            'label' => 'Publier'
        ));

        $form->add('preview',
            'Symfony\Component\Form\Extension\Core\Type\SubmitType',
            //'submit',
            array(
            'label' => 'Prévisualiser'
        ));

        return $form;
    }

    /**
     * Submits space
     *
     * @param Space $space
     *
     * @return RedirectResponse
     */
    protected function submitSpace($space)
    {
        $isAdmin = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        
        $space->setSubmitted(true);
        
        // Si c'est un admin, on publie directement l'espace
        if ($isAdmin) {
            $space->setEnabled(true);
            $this->get('doctrine.orm.entity_manager')->flush();
            
            // Envoyer un email au propriétaire pour l'informer de la publication
            $owner = $space->getOwner();
            if ($owner && $owner->getEmail()) {
                try {
                    $message = (new \Swift_Message())
                        ->setSubject('Votre espace a été publié')
                        ->setFrom($this->container->getParameter('mail_confirmation_from'))
                        ->setTo($owner->getEmail())
                        ->setBody(
                            $this->renderView(
                                'AppBundle:Email:space_published.html.twig',
                                compact('space')
                            ), 'text/html'
                        )
                    ;
                    $this->get('mailer')->send($message);
                } catch (\Exception $e) {
                    $this->get('logger')->error('Échec envoi email publication espace au propriétaire (submitSpace admin)', ['exception' => $e, 'space_id' => $space->getId()]);
                }
            }
            
            $this->get('session')->getFlashBag()->set('success', 'L\'espace a été publié avec succès.');
            return $this->redirect($this->generateUrl('space_manager_list', array('create_confirm' => '1', 'published' => '1')));
        } else {
            // Propriétaire standard : soumettre pour validation
            $this->get('doctrine.orm.entity_manager')->flush();
            
            // Envoyer un email aux admins pour validation
            try {
                $message = (new \Swift_Message())
                    ->setSubject('Nouvelle propriété en attente de validation')
                    ->setFrom($this->container->getParameter('mail_confirmation_from'))
                    ->setTo($this->container->getParameter('mail_confirmation_to'))
                    ->setBody(
                        $this->renderView(
                            'AppBundle:Email:new_property.html.twig',
                            compact('space')
                        ), 'text/html'
                    )
                ;
                $this->get('mailer')->send($message);
            } catch (\Exception $e) {
                $this->get('logger')->error('Échec envoi email nouvelle propriété aux admins', ['exception' => $e, 'space_id' => $space->getId()]);
            }
            
            $this->get('session')->getFlashBag()->set('success', 'Votre espace a été soumis pour validation. Un administrateur le publiera après vérification.');
            return $this->redirect($this->generateUrl('space_manager_list', array('submit_confirm' => '1')));
        }
    }



    /**
     * @param Request $request
     * @param array   $data
     *
     * @return Form
     */
    protected function handleFilterForm(Request $request, $data)
    {
        $builder = $this->get('form.factory')->createNamedBuilder('filter', 'form', $data, array(
            'action' => $this->generateUrl('space_manager_candidates', array('id' => $request->get('space')->getId())),
            'method' => 'get',
            'csrf_protection' => false
        ));

        $builder->add('sort_field',
            //'choice',
            'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
            array(
            'required' => false,
            'choices' => array_flip(array(
                'wishedSize' => 'Surface souhaitée (candidature)',
                'startOccupation' => 'Date d\'entrée souhaitée',
                'lengthOccupation' => 'Durée d\'occupation',
                'created' => 'Date de candidature'
            )),
            'choices_as_values' => true,
            'placeholder' => 'Trier par',
            'empty_data' => 'created'
        ));

        $builder->add('status_filter', 'choice', array(
            'required' => false,
            'choices' => array_flip([
                Application::UNREAD_STATUS => 'Non lue',
                Application::WAIT_STATUS => 'En attente',
                Application::ACCEPT_STATUS => 'Accepté',
                Application::REJECT_STATUS => 'Refusé',
                'selected' => 'Sélectionnés'
            ]),
            'placeholder' => 'Filtrer par',
            'empty_data' => ''
        ));

        $builder->add('sort_order', 'choice', array(
            'required' => false,
            'expanded' => true,
            'placeholder' => false,
            'choices' => array_flip([
                'asc' => 'Trier par ordre croissant',
                'desc' => 'Trier par ordre décroissant'
            ]),
            'empty_data' => 'desc'
        ));

        $form = $builder->getForm();
        $form->handleRequest($request);

        return $form;
    }

    /**
     * @param Request $request
     * @param array   $data
     *
     * @return Form
     */
    protected function handleSpaceFilterForm(Request $request, $data)
    {
        $builder = $this->get('form.factory')->createNamedBuilder('filter', 'form', $data, array(
            'action' => $this->generateUrl('space_manager_list'),
            'method' => 'get',
            'csrf_protection' => false
        ));

        $builder->add('sort_field', 'choice', array(
            'required' => false,
            'choices' => array_flip([
                'type' => 'Type de local',
                'limitAvailability' => 'Date de clôture',
                'city' => 'Localité',
                'name' => 'Nom du bâtiment'
            ]),
            'placeholder' => 'Trier par',
            'empty_data' => ''
        ));

        // Vérifier si l'utilisateur est admin pour ajouter l'option "En attente de publication"
        $isAdmin = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        
        $statusChoices = [
            'enabled' => 'Projets en cours',
            'closed'  => 'Projets clôturés',
        ];
        
        if ($isAdmin) {
            $statusChoices['pending'] = 'En attente de publication';
        }
        
        $builder->add('status_filter', 'choice', array(
            'required' => false,
            'choices' => array_flip($statusChoices),
            'placeholder' => 'Filtrer par',
            'empty_data' => ''
        ));

        $builder->add('sort_order', 'choice', array(
            'required' => false,
            'expanded' => true,
            'placeholder' => false,
            'choices' => array_flip([
                'asc' => 'Trier par ordre croissant',
                'desc' => 'Trier par ordre décroissant'
            ]),
            'empty_data' => 'desc'
        ));

        $form = $builder->getForm();
        $form->handleRequest($request);

        return $form;
    }
}
