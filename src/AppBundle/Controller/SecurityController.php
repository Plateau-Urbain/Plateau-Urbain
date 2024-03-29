<?php
// vim:expandtab:sw=4 softtabstop=4:
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Application;
use AppBundle\Entity\UserDocument;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
    public function loginFormAction(Request $request) {
        //$request = $this->container->get('request');

        $session = $request->getSession();

        // use now csrf_token('authenticate')
        //$csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(Security::LAST_USERNAME);

        return array(
            //'csrf_token' => $csrfToken,
            'last_username' => $lastUsername,
        );
   }

    /**
     * @Route("/login", name="security_login_error")
     * @Template()
     */
    public function loginAction()
    {
        $logger = $this->get('logger');
        $user = $this->getUser();
        if (!is_null($user)) {
            $logger->debug('loginAction() user '.$user->getId().' '.$user->getUsername().' '.($this->getUser()->isProprio() ? 'PROPRIO' : ''));
        }
        else {
            $logger->info('loginAction() utilisateur pas connecté');
            // En vrai on peut arriver sur cette page directement sans que ce soit suite à un mauvais mot de passe. Mais cette page n'est pas visible publiquement.
            $this->get('session')->getFlashBag()->set('error_msg', "Erreur dans le mot de passe ou le nom d'utilisateur");
        }
        return array();
    }

    /**
     * @Route("/profil", name="security_profil")
     * @Route("/inscription/confirmation", name="fos_user_registration_confirmed")
     */
    public function inscriptionConfirmationAction(Request $request)
    {
        $user = $this->getUser();
        return $this->redirect($this->generateUrl('security_profil_role', array('role' => $user->isProprio() ? 'proprio' : 'candidat')));
    }

    /**
     * @Route("/profil/{role}", name="security_profil_role")
     */
    public function profilAction(Request $request)
    {
        $logger = $this->get('logger');
        $user = $this->getUser();
        $em   = $this->getDoctrine()->getManager();

        $logger->debug('profilAction() user '.$user->getId().' '.$user->getUsername().' '.($this->getUser()->isProprio() ? 'PROPRIO' : ''));
        if ($this->getUser()->isProprio() && $request->get('role') == 'proprio') {
            // Passing type instances to FormBuilder::add(), Form::add()
            // or the FormFactory is deprecated since Symfony 2.8 and
            // will not be supported in 3.0.
            // Use the fully-qualified type class name instead
            $form = $this->createForm(SpaceOwnerType::class, $user);
            $template = 'AppBundle:Security:profilProprio.html.twig';
        } elseif( $request->get('role') == 'candidat') {
            $form = $this->createForm(ProjectOwnerType::class, $user, array('noPlainPassword' => true));

            $template = 'AppBundle:Security:profil.html.twig';
        } else {
            throw new AccessDeniedException();
        }
        $session = $this->get('session');
        $current_ppassword = $user->getPassword();

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        if (! $form->handleRequest($request)->isSubmitted()) {
            return $this->render($template, [
                'form' => $form->createView()
            ]);
        }

        if (! $form->isValid()) {
            return $this->render($template, [
                'form' => $form->createView()
            ]);
        }

        $old_pwd = $this->getUser()->isProprio() && $form->get('userInfo')->has('oldPassword') ? $form->get('userInfo')->get('oldPassword')->getData() : '';
        $new_pwd = $this->getUser()->isProprio() && $form->get('userInfo')->has('plainPassword') ? $form->get('userInfo')->get('plainPassword')->getData() : '';

        // si pas de changement de mot de passe
        if (empty($old_pwd) || empty($new_pwd)) {
            $em->persist($user);
            $em->flush();

            $session->getFlashBag()->set('success_msg', "Profil mis à jour");
            return $this->redirect($this->generateUrl('security_profil'));
        }

        $old_pwd_encoded = $encoder->encodePassword($old_pwd, $user->getSalt());

        if($current_ppassword != $old_pwd_encoded) {
            $session->getFlashBag()->set('error_msg', "Erreur dans le mot de passe actuel");
            return $this->redirect($this->generateUrl('security_profil'));
        }

        $new_pwd_encoded = $encoder->encodePassword($new_pwd, $user->getSalt());
        $user->setPassword($new_pwd_encoded);
        $em->persist($user);
        $em->flush();

        $session->getFlashBag()->set('success_msg', "Profil mis à jour");
        return $this->redirect($this->generateUrl('security_profil'));
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
      $user = $this->getUser();

      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Application');

      $prevApplication = $repository->getApplicantPrevApplication($application, $user);
      $nextApplication = $repository->getApplicantNextApplication($application, $user);

      return array(
          'prevApplication'   => $prevApplication,
          'nextApplication'   => $nextApplication,
          'application'       => $application
      );
    }

    /**
     * @Route("/document/{id}/delete", name="profile_removedocument")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeDocumentAction(Request $request, UserDocument $userDocument)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->remove($userDocument);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Le document a été supprimé.');

        if ($request->get('service')) {
            return $this->redirect($request->get('service'));
        }

        return $this->redirect($this->generateUrl('security_profil'));
    }

    /**
     * @param Request $request
     * @param array   $data
     *
     * @return Form
     */
    protected function handleApplicationsFilterForm(Request $request, $data)
    {
      // Accessing type "form" by its string name is deprecated since
      // Symfony 2.8 and will be removed in 3.0. Use the
      // fully-qualified type class name
      // "Symfony\Component\Form\Extension\Core\Type\FormType" instead
      $builder = $this->get('form.factory')->createNamedBuilder('filter',
            'Symfony\Component\Form\Extension\Core\Type\FormType',//'form',
            $data, array(
                'action' => $this->generateUrl('my_applications_list'),
                'method' => 'get',
                'csrf_protection' => false
            ));

      // Accessing type "choice" by its string name is deprecated since
      // Symfony 2.8 and will be removed in 3.0. Use the fully-qualified
      // type class name
      // "Symfony\Component\Form\Extension\Core\Type\ChoiceType" instead.
      $builder->add('sort_field', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
         array(
          'required' => false,
          'choices' => array_flip(array(
              'type' => 'Type de local',
              'limitAvailability' => 'Date de clôture',
              'city' => 'Localité',
              'name' => 'Nom du bâtiment'
          )),
          'choices_as_values' => true,
          'placeholder' => 'Trier par',
          'empty_data' => ''
      ));

      $builder->add('status_filter', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
         array(
          'required' => false,
          'choices' => array_flip(array(
              'draft' => 'À compléter',
              'sent'  => 'Envoyées',
              'accepted' => 'Acceptées',
              'rejected'  => 'Refusées',
          )),
          'choices_as_values' => true,
          'placeholder' => 'Filtrer par',
          'empty_data' => ''
      ));

      $builder->add('sort_order', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
         array(
          'required' => false,
          'expanded' => true,
          'placeholder' => false,
          'choices' => array_flip(array(
              'asc' => 'Trier par ordre croissant',
              'desc' => 'Trier par ordre décroissant'
          )),
          'choices_as_values' => true,
          'empty_data' => 'desc'
      ));

      $form = $builder->getForm();
      $form->handleRequest($request);

      return $form;
    }
}
