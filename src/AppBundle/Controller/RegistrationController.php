<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{
    public function registerAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);

        if ($process) {
            $user = $form->getData();

            $route = 'fos_user_registration_confirmed';

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            $this->authenticateUser($user, $response);

            return $response;
        } else if ($process == false && 'POST' === $this->container->get('request')->getMethod()) {
            $url = $this->container->get('router')->generate("homepage");
            $response = new RedirectResponse($url);

            $this->setFlash('error_sign', 'Erreur lors de l\'inscription, veuillez vérifier votre e-mail et votre mot de passe.');
            return $response;
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));
    }

}