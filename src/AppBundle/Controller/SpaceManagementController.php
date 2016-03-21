<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Entity\Parcel;
use AppBundle\Entity\Space;
use AppBundle\Entity\SpaceImage;
use AppBundle\Entity\SpaceDocument;
use Exporter\Handler;
use Exporter\Source\DoctrineORMQuerySourceIterator;
use Exporter\Writer\CsvWriter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $user = $this->get('security.context')->getToken()->getUser();

        // Handle the filter form
        $filterForm = $this->handleSpaceFilterForm($request, array(
            'sort_field' => 'created',
            'sort_order' => 'desc',
            'status_filter' => null
        ));

        $filters = $filterForm->getData();

        $params = array(
            'user'      => $user,
            'orderBy'   => $filters['sort_field'],
            'sort'      => $filters['sort_order']
        );

        if ($filters['status_filter'] == 'closed') {
            $params['closed'] = true;
        } else if ($filters['status_filter'] == 'enabled')  {
            $params['enabled'] = true;
        }

        $query = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space')->filter($params);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/
        );


        return array(
            "pagination" => $pagination,
            'filterForm' => $filterForm->createView()
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

        $form = $this->createSpaceForm($space, array(
            'action' => $this->generateUrl('space_manager_add'),
            'method' => 'post'
        ));

        $space->setOwner($this->getUser());

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

        return array('form' => $form->createView());
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
        // Check ownership
        if (!$space->isOwner($this->getUser()) || $space->isSubmitted()) {
            throw new AccessDeniedException();
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
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/close/{id}", name="space_manager_close")
     */
    public function closeAction(Space $space)
    {
        $space->setClosed(true);

        $em = $this->getDoctrine()->getManager();

        $em->persist($space);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Espace fermé');

        return $this->redirect($this->generateUrl('space_manager_list'));
    }

    /**
     * @Route("/candidats/{id}", name="space_manager_candidates", methods={"get", "post"}, requirements={"id": "\d+"})
     * @Template()
     */
    public function candidatesAction(Request $request, Space $space)
    {
        if ($request->isMethod('post')) {
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

                if (!$application || !$application->isAwaiting()) {
                    // Already processed
                    continue;
                }

                if ($action == 'accept') {
                    $application->setStatus(Application::ACCEPT_STATUS);
                } elseif ($action == 'refuse') {
                    $application->setStatus(Application::REJECT_STATUS);
                }

                $message = \Swift_Message::newInstance()
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
            10
        );

        $useTypes = $this->getDoctrine()->getManager()->getRepository('AppBundle:UseType')->findBy(array(), array('name' => 'ASC'));
        $categories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findBy(array(), array('name' => 'ASC'));

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
                'Statut' => 'statusLabel',
                'Nom' => 'name',
                'Structure' => 'projectHolder.company',
                'Nom du porteur' => 'projectHolder.fullName',
                'Description' => 'description',
                'Date de dépôt de la candidature' => 'created',
                'Type de projet' => 'category',
                'Surface recherchée' => 'wishedSize',
                'Durée d\'occupation souhaitée' => 'fullLengthOccupation',
                'Date d\'entrée souhaitée' => 'startOccupation'
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
     * @Route("/application/{id}/toggle_selected", name="space_manager_toggle_selected_application", methods={"get", "post"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function toggleSelectedApplication(Request $request, Application $application)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $application->setSelected(!$application->getSelected());

        $em->persist($application);
        $em->flush();

        return $this->redirect($request->server->get('HTTP_REFERER') . "#listing-header");
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
        if (!$image->getSpace()->isOwner($this->getUser())) {
            throw new AccessDeniedException();
        }

        // Check csrfToken
        if (!$this->get('form.csrf_provider')->isCsrfTokenValid('remove_image', $request->query->get('token'))) {
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
        if (!$image->getSpace()->isOwner($this->getUser())) {
            throw new AccessDeniedException();
        }

        // Check csrfToken
        if (!$this->get('form.csrf_provider')->isCsrfTokenValid('move_image', $request->query->get('token'))) {
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
     * @Route("/document/{id}/delete", name="space_manager_removedocument")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeDocumentAction(Request $request, SpaceDocument $spaceDocument)
    {
        if (!$spaceDocument->getSpace()->isOwner($this->getUser())) {
            throw new AccessDeniedException();
        }

        $spaceId = $spaceDocument->getSpace()->getId();

        $em = $this->get('doctrine.orm.entity_manager');
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
        if (!$parcel->getSpace()->isOwner($this->getUser())) {
            throw new AccessDeniedException();
        }

        // Check csrfToken
        if (!$this->get('form.csrf_provider')->isCsrfTokenValid('remove_parcel', $request->query->get('token'))) {
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
     * @param Space $data
     * @param array $options
     *
     * @return Form
     */
    protected function createSpaceForm($data, array $options = array())
    {
        $options['attr']['novalidate'] = true;

        $form = $this->createForm('appbundle_space', $data, $options);

        $form->add('publish', 'submit', array(
            'label' => 'Publier'
        ));

        $form->add('preview', 'submit', array(
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
        $space->setSubmitted(true);

        $this->get('doctrine.orm.entity_manager')->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Nouvelle propriété ! ')
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

        $this->get('session')->getFlashBag()->set('success', 'L\'espace a été crée');

        return $this->redirect($this->generateUrl('space_manager_list', array('create_confirm' => '1')));
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

        $builder->add('sort_field', 'choice', array(
            'required' => false,
            'choices' => array(
                'wishedSize' => 'Surface recherchée',
                'startOccupation' => 'Date d\'entrée souhaitée',
                'lengthOccupation' => 'Durée d\'occupation',
                'created' => 'Date de candidature'
            ),
            'empty_value' => 'Trier par',
            'empty_data' => 'created'
        ));

        $builder->add('status_filter', 'choice', array(
            'required' => false,
            'choices' => array(
                Application::UNREAD_STATUS => 'Non lue',
                Application::WAIT_STATUS => 'En attente',
                Application::ACCEPT_STATUS => 'Accepté',
                Application::REJECT_STATUS => 'Refusé',
                'selected' => 'Sélectionnés'
            ),
            'empty_value' => 'Filtrer par',
            'empty_data' => ''
        ));

        $builder->add('sort_order', 'choice', array(
            'required' => false,
            'expanded' => true,
            'empty_value' => false,
            'choices' => array(
                'asc' => 'Trier par ordre croissant',
                'desc' => 'Trier par ordre décroissant'
            ),
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
            'choices' => array(
                'type' => 'Type de local',
                'limitAvailability' => 'Date de clôture',
                'city' => 'Localité',
                'name' => 'Nom du bâtiment'
            ),
            'empty_value' => 'Trier par',
            'empty_data' => ''
        ));

        $builder->add('status_filter', 'choice', array(
            'required' => false,
            'choices' => array(
                'enabled' => 'Projets en cours',
                'closed'  => 'Projets clôturés',
            ),
            'empty_value' => 'Filtrer par',
            'empty_data' => ''
        ));

        $builder->add('sort_order', 'choice', array(
            'required' => false,
            'expanded' => true,
            'empty_value' => false,
            'choices' => array(
                'asc' => 'Trier par ordre croissant',
                'desc' => 'Trier par ordre décroissant'
            ),
            'empty_data' => 'desc'
        ));

        $form = $builder->getForm();
        $form->handleRequest($request);

        return $form;
    }
}
