<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $isLogged = $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY');

        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav navbar-nav',
        )));

        if ($isLogged) {
            $menu->addChild('Rechercher', array('route' => 'search_index'));

            $context = $this->container->get('security.context');
            $user = $context->getToken()->getUser();

            if ($user->isProprio() || $context->isGranted('ROLE_OWNER')) {
                $menu->addChild('Proposer', array('route' => 'space_manager_add'));
            }

            $menu->addChild('Comment ça marche', array('uri' => 'http://www.plateau-urbain.com/#!accueil/c66t', 'linkAttributes' => array('target' => '_blank')));
            $menu->addChild('S’inscrire', array('uri' => '#inline_register_content',  'linkAttributes' => array('class' => 'inline cboxElement')));
            $menu->addChild('Contact', array('uri' => '#footer'));
            $loggedMenu = $menu->addChild('Mon compte', array('uri' => '#', 'extras' => array(
                'safe_label' => true
            ), 'linkAttributes' => array('data-toggle' => 'dropdown', 'data-hover' => 'dropdown')));
            $loggedMenu->setChildrenAttribute('class', 'dropdown-menu');

            $loggedMenu->addChild('Mon profil', array('route' => 'security_profil'));

            if ($user->isProprio() || $context->isGranted('ROLE_OWNER')) {
                $loggedMenu->addChild('Mes espaces', array('route' => 'space_manager_list'));
                $loggedMenu->addChild('Ajouter un espace', array('route' => 'space_manager_add'));
            } else if ($user->isPorteur() || $context->isGranted('ROLE_PROJECT_HOLDER')) {
                $loggedMenu->addChild('Mes candidatures', array('route' => 'my_applications_list'));
            }

            $loggedMenu->addChild('Déconnexion', array('route' => 'fos_user_security_logout'));

        } else {
            $menu->addChild('Rechercher', array('uri' => '#inline_content', 'linkAttributes' => array('class' => 'inline cboxElement')));
            $menu->addChild('Proposer', array('uri' => '#inline_content', 'linkAttributes' => array('class' => 'inline cboxElement')));
            $menu->addChild('Comment ça marche', array('uri' => 'http://www.plateau-urbain.com/#!accueil/c66t', 'linkAttributes' => array('target' => '_blank')));
            $menu->addChild('S’inscrire', array('uri' => '#inline_register_content',  'linkAttributes' => array('class' => 'inline cboxElement')));
            $menu->addChild('Contact', array('uri' => '#footer'));
            $menu->addChild("Se connecter", array('uri' => '#inline_content', 'extras' => array('safe_label' => true), 'linkAttributes' => array('class' => 'inline cboxElement connectMenu')));
        }

       return $menu;
    }
}
