<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Actuality;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Actuality controller.
 *
 * @Route("/slider")
 **/
class ActualityController extends Controller
{
    /**
     * @Route("/show", name="show_actualities")
     * @Template()
     */
    public function showAction()
    {
      $repository = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Actuality');
      $actualities = $repository->findPublished();

      return $this->render(
          'AppBundle:Default:_actualities.html.twig',
          array('actualities' => $actualities)
      );
    }

}
