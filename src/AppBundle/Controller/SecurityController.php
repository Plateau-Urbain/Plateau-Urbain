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
        $em   = $this->getDoctrine()->getManager();

        if ($this->getUser()->isProprio()) {
            $form = $this->createForm(new SpaceOwnerType(), $user);
            $template = 'AppBundle:Security:profilProprio.html.twig';
        } else {
            $form = $this->createForm(new ProjectOwnerType(), $user);
            $template = 'AppBundle:Security:profil.html.twig';
        }
        $session = $this->get('session');
        $current_ppassword = $user->getPassword();

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        if ($form->handleRequest($request)->isValid()) {


            $old_pwd = $this->getUser()->isProprio() ? $form->get('oldPassword')->getData() : '';
            $new_pwd = $this->getUser()->isProprio() ? $form->get('password')->getData() : '';

            if (!empty($old_pwd) || !empty($new_pwd)) {

                $old_pwd_encoded = $encoder->encodePassword($old_pwd, $user->getSalt());

                if($current_ppassword != $old_pwd_encoded) {
                    $session->getFlashBag()->set('error_msg', "Erreur dans le mot de passe actuel");
                } else {
                    $new_pwd_encoded = $encoder->encodePassword($new_pwd, $user->getSalt());
                    $user->setPassword($new_pwd_encoded);
                    $em->persist($user);
                    $em->flush();

                    return $this->redirect($this->generateUrl('homepage'));
                }
            } else {
                $new_pwd = $form->get('password')->getData();

                if (!empty($new_pwd)) {
                    $user->setPassword($encoder->encodePassword($new_pwd, $user->getSalt()));
                } else {
                    $user->setPassword($current_ppassword);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($this->getUser());
                $em->flush();

                return $this->redirect($this->generateUrl('homepage'));
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

    public function myApplicationsAction(Request $request)
    {
        // Handle the filter form
        $filterForm = $this->handleApplicationsFilterForm($request, array(
            'sort_field' => 'created',
            'sort_order' => 'desc',
            'status_filter' => null
        ));

        $filters = $filterForm->getData();

        $params = array(
            'applicant' => $this->getUser(),
            'orderBy'   => $filters['sort_field'],
            'status'    => $filters['status_filter'],
            'sort'      => $filters['sort_order']
        );

        $applications = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application')
          ->formFilter($params);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $applications,
            $request->query->getInt('page', 1)
        );

        return array(
            "applications" => $pagination,
            'filterForm' => $filterForm->createView()
        );

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


    /**
     * @param Request $request
     * @param array   $data
     *
     * @return Form
     */
    protected function handleApplicationsFilterForm(Request $request, $data)
    {

      $builder = $this->get('form.factory')->createNamedBuilder('filter', 'form', $data, array(
          'action' => $this->generateUrl('my_applications_list'),
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
              'draft' => 'À compléter',
              'sent'  => 'Envoyées',
              'accepted' => 'Acceptées',
              'rejected'  => 'Refusées',
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
