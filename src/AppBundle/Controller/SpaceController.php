<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Entity\Space;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Space');
        $spaces = $em->findAll();

        return compact('spaces');
    }

    /**
     * @Route("/fiche/{id}", name="space_show")
     * @Template()
     */
    public function showAction(Space $space, Request $request)
    {
        $user = $this->getUser();
        
        if (!$space->isEnabled() && $space->getOwner()->getId() != $user->getId() || 
            $space->isClosed() && $space->getOwner()->getId() != $user->getId()) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException;
        }
        
        $em = $this->getDoctrine()->getManager();
        $application = new Application();

        //set some defaults
        $application->setDescription($user->getprojectDescription());
        $application->setLengthOccupation($user->getUsageDuration());
        $application->setLengthTypeOccupation($user->getLengthTypeOccupation());

        $form = $this->createForm('appbundle_application', $application, array('action'=>$this->generateUrl('space_show', array('id' => $space->getId()))));

        $invalidProfile = true;

        if ($form->handleRequest($request)->isValid()) {
            $application->setProjectHolder($this->getUser());
            $application->setSpace($space);
            
            $application->setStatus(Application::WAIT_STATUS);

            $em->persist($application);
            $em->flush();

            return new RedirectResponse($this->generateUrl('space_show', array('id'=>$space->getId()))."#espace_confirmation") ;
        }

        $applicated = false;
        if ($user) {
            //Check if the profile is completed
            $errors = $this->container->get('validator')->validate($user);
            $invalidProfile = (count($errors) > 0) ? true : false;

            //Check if this user have an active application for this space.
            $applicated = $em->getRepository('AppBundle:Application')->findOneBy(
                array('projectHolder' => $user,
                      'space' => $space ) );
        }


        return array(
            'space'          => $space,
            'form'           => $form->createView(),
            'invalidProfile' => $invalidProfile,
            'applicated'     => $applicated
        );
    }

     /**
     * @Route("/pic_show/{img_id}", name="space_pic_show")
     */
    public function picShowAction($img_id)
    {

        $pic = $this->getDoctrine()->getManager()->getRepository("AppBundle:SpaceImage")->find($img_id);
        return $this->render( 'AppBundle:Space/Partials:picShow.html.twig',compact('pic'));
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
