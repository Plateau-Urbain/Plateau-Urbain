<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Space;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        
        return array("pagination" => $pagination);
    }

    /**
     * @Route("/ajouter", name="space_manager_add")
     * @Template()
     */
    public function addAction(Request $request)
    { 
        $space = new Space();
        $form = $this->createForm('appbundle_space', $space);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $space->setEnabled(false);
            $space->setClosed(false);
            $space->setOwner($this->get('security.context')->getToken()->getUser());
            
            foreach ($space->getPics() as $pic) {
                $pic->setSpace($space);
                $em->persist($pic);
            }
                        
            $em->persist($space);
            $em->flush();
//
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
//            $this->get('mailgun.swift_transport.transport')->send($message);
            $this->get('session')->getFlashBag()->set('success', 'L\'espace a été crée');

            return $this->redirect($this->generateUrl('space_manager_list'));
        }

        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/close/{id}", name="space_manager_close")
     * @Template()
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
    public function candidatesAction(Space $space)
    {
        return array(
            'space' => $space
        );
    }    
    
    
}
