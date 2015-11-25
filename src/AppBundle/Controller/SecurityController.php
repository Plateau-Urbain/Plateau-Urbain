<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Application;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProjectOwnerType;
use AppBundle\Form\SpaceOwnerType;

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
     * @Route("/inscription/confirmation", name="fos_user_registration_confirmed")
     */
    public function profilAction(Request $request)
    {
        $user = $this->getUser();

        if ($this->getUser()->isProprio()) {
            $form = $this->createForm(new SpaceOwnerType(), $user);
            $template = 'AppBundle:Security:profilProprio.html.twig';
        } else {
            $form = $this->createForm(new ProjectOwnerType(), $user);           
            $template = 'AppBundle:Security:profil.html.twig';
        }
        $session = $this->get('session');
        $current_ppassword = $user->getPassword();
        
        if ($form->handleRequest($request)->isValid()) {

            
            $old_pwd = $this->getUser()->isProprio() ? $form->get('oldPassword')->getData() : '';
            $new_pwd = $this->getUser()->isProprio() ? $form->get('password')->getData() : '';
            
            if (!empty($old_pwd) || !empty($new_pwd)) {

                $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
                $old_pwd_encoded = $encoder->encodePassword($old_pwd, $user->getSalt());
        
                if($current_ppassword != $old_pwd_encoded) {
                    $session->getFlashBag()->set('error_msg', "Erreur dans le mot de passe actuel");
                } else {
                    $new_pwd_encoded = $encoder->encodePassword($new_pwd, $user->getSalt());
                    $user->setPassword($new_pwd_encoded);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($user);

                    $manager->flush();
                }
            } else {            
                $em = $this->getDoctrine()->getManager();
                $em->persist($this->getUser());
                $em->flush();
            }
        }
        
        return $this->render($template, array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/mes-candidatures", name="my_applications_list")
     * @Template()
     */

    public function myApplicationsAction()
    {
        $applications = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')->findBy(array(
            'projectHolder' => $this->getUser()
        ));

        return compact('applications');

    }

    /**
     * @Route("/mes-candidatures/{id}", name="my_application_show")
     * @ParamConverter("application", class="AppBundle:Application")
     * @Template()
     */
    public function showMyApplicationAction(Application $application)
    {
        return compact('application');
    }
}
