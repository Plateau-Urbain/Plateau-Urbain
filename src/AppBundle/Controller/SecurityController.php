<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProjectOwnerType;

/**
 * Security controller.
 **/
class SecurityController extends Controller
{
    /**
     * @Route("/security_login", name="security_login")
     * @Template()
     */
    public function loginFormAction() {
        $request = $this->container->get('request');

        $session = $request->getSession();

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        return array(
            'csrf_token' => $csrfToken,
            'last_username' => $lastUsername,
        );
   }

    /**
     * @Route("/login", name="security_login_error")
     * @Template()
     */
    public function loginAction()
    {
        return array();
    }
    
    /**
     * @Route("/profil", name="security_profil")
     * @Template()
     */
    public function profilAction(Request $request)
    {
        $form = $this->createForm(new ProjectOwnerType(), $this->getUser());
        
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($this->getUser());
            $em->flush();
        }
        
        return array(
            'form' => $form->createView()
        );
    }
}