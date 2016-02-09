<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/mentions-legales", name="mentions_legales")
     * @Template()
     */
    public function legalAction()
    {
        return array();
    }

    /**
     * @Route("/cgu", name="cgu")
     * @Template()
     */
    public function cgu2Action()
    {
        return array();
    }

    /**
     * @Route("/proprietaire", name="proprietaire")
     * @Template()
     */
    public function ownerAction()
    {
        return array();
    }

    /**
     * @Route("/upload_action", name="upload_action")
     * @Template()
     */
    public function uploadAction()
    {
        return array();
    }
}
