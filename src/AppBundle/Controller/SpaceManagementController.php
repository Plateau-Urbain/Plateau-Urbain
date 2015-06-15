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
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space');
        $spaces = $em->findBy(array('owner' => $user->getId()));

        return compact('spaces');
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
            $space->setEnabled(false);
            $space->setOwner($this->get('security.context')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
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
            $this->get('session')->getFlashBag()->set('success', 'La propriété a été crée');

            return $this->redirect($this->generateUrl('space_manager_list'));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/editer/{id}", name="space_manager_edit")
     * @Template()
     */
    public function editAction(Space $space)
    {
        $form = $this->createForm('appbundle_space', $space);

        return array('form' => $form->createView());
    }
}
