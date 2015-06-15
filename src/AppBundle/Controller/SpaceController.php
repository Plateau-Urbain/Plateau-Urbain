<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Entity\Space;
use AppBundle\Form\ApplicationType;
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
     * @Route("/voir/{id}", name="space_show")
     * @Template()
     */

    public function showAction(Space $space, Request $request)
    {
        $application = new Application();
        $form = $this->createForm('appbundle_application', $application);

        if($form->handleRequest($request)->isValid())
        {
            $application->setProjectHolder($this->getUser());//
            $application->setSpace($space);

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return new RedirectResponse('space_confirmation') ;

        }

        return array(
            'space'=>$space,
            'form'=>$form->createView(),
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
