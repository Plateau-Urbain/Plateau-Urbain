<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Space;
use AppBundle\Entity\SpaceImage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     
        $params = array(
            'user'      => $user,
            'orderBy'   => $request->get('orderBy', 'zipCode'),
            'sort'      => $request->get('sort', 'ASC'),
        );

        $query = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space')->filter($params);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/
        );

        
        return array(
            "pagination" => $pagination
        );
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

            $this->get('session')->getFlashBag()->set('success', 'L\'espace a été enregistré.');

            // Default is edition
            return $this->redirect($this->generateUrl('space_manager_edit', array('id' => $space->getId())));
        }

        $errors = $this->get('validator')->validate($space);

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
     * @Route("/candidats/{id}", name="space_manager_candidates")
     * @Template()
     */
    public function candidatesAction(Request $request, Space $space)
    {
        if ($request->getMethod() == 'POST') {
            $em         = $this->getDoctrine()->getManager();
                    
            $ids        = $request->get('applications');
            $message    = $request->get('message');
            $action     = $request->get('action');
                    
            $ids = explode('-', $ids);        
            foreach ($ids as $id) {
                
                $application = $em->getRepository('AppBundle:Application')->find($id);
                        
                if ($action == 'accept') {
                    $application->setStatus(\AppBundle\Entity\Application::ACCEPT_STATUS);
                } elseif ($action == 'refuse') {
                    $application->setStatus(\AppBundle\Entity\Application::REJECT_STATUS);                    
                }
                
                //TODO : send mail
                $message = \Swift_Message::newInstance()
                    ->setSubject($action == 'accept' ? 'Candidature Acceptée' : 'Candidature rejetée')
                    ->setFrom($this->container->getParameter('mail_confirmation_from'))
                    ->setTo($application->getProjectHolder()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'AppBundle:Email:candidate.html.twig', 
                                array('space' => $space, 'message' => $message, 'user' => $application->getProjectHolder())
                        ), 'text/html'
                    )
                ;

                $this->get('mailer')->send($message);
                
                
                $em->persist($application);
            }
            
            
            $em->flush();
            
        }

            
        $params = array(
            'space'     => $space,
            'orderBy'   => $request->get('orderBy', 'lengthOccupation'),
            'sort'      => $request->get('sort', 'ASC'),
        );

        $query = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->filter($params);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/
        );
        
        return array(
            'space'         => $space,
            'pagination'    => $pagination
        );
    }

    /**
     * @Route("/photo/{id}/delete", name="space_manager_removepicture", methods={"delete"})
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

        $form->add('save', 'submit', array(
            'label' => 'Enregistrer'
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

//            $message = \Swift_Message::newInstance()
//                ->setSubject('Nouvelle propriété ! ')
//                ->setFrom($this->container->getParameter('mail_confirmation_from'))
//                ->setTo($this->container->getParameter('mail_confirmation_to'))
//                ->setBody(
//                    $this->renderView(
//                        'AppBundle:Email:new_property.html.twig',
//                        compact('space')
//                    ), 'text/html'
//                )
//            ;
//
//            $this->get('mailer')->send($message);

        $this->get('session')->getFlashBag()->set('success', 'L\'espace a été crée');

        return $this->redirect($this->generateUrl('space_manager_list'));
    }
}
