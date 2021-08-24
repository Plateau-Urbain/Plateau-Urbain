<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        // security.context is deprecated in symfony 2.6
        // replace by 'security.token_storage' and 'security.authorization_checker'
        // https://symfony.com/blog/new-in-symfony-2-6-security-component-improvements
        $isLogged = $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY');

        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav navbar-nav',
        )));

        $menu->addChild('Rechercher', array('route' => 'search_index'));

        if ($isLogged) {

            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $context = $this->container->get('security.authorization_checker');

            if ($user->isProprio() || $context->isGranted('ROLE_OWNER')) {
                $menu->addChild('Proposer un espace', array('route' => 'space_manager_add'));
            }

            $menu->addChild('Comment ça marche', array('uri' => 'http://www.plateau-urbain.com/#!plate-forme/eqbhd', 'linkAttributes' => array('target' => '_blank')));
            $menu->addChild('Contact', array('uri' => '#footer'));
            $loggedMenu = $menu->addChild('Mon compte', array('uri' => '#', 'attributes' => array('class'=>'dropdown'), 'extras' => array(
                'safe_label' => true
            ),'linkAttributes' => array('data-toggle' => 'dropdown', 'data-hover' => 'dropdown')));
            $loggedMenu->setChildrenAttribute('class', 'dropdown-menu');

            $loggedMenu->addChild('Mon profil', array('route' => 'security_profil', 'attributes' => array('class'=>'user-icon menu-icon')));

            if ($user->isProprio() || $context->isGranted('ROLE_OWNER')) {
              $loggedMenu->addChild('Mes espaces', array('route' => 'space_manager_list', 'attributes' => array('class'=>'spaces-icon menu-icon')));
              $loggedMenu->addChild('Ajouter un espace', array('route' => 'space_manager_add', 'attributes' => array('class'=>'add-icon menu-icon')));

              if ($context->isGranted('ROLE_ADMIN')) {
                $loggedMenu->addChild('Liste des AACs', ['route' => 'aac_list', 'attributes' => ['class' => 'bulb-icon menu-icon']]);
              }
            } else if ($user->isPorteur() || $context->isGranted('ROLE_PROJECT_HOLDER')) {
              $loggedMenu->addChild('Mes candidatures', array('route' => 'my_applications_list', 'attributes' => array('class'=>'bulb-icon menu-icon')));
            }

            $loggedMenu->addChild('Déconnexion', array('route' => 'fos_user_security_logout', 'attributes' => array('class'=>'off-icon menu-icon')));

        } else {
            $menu->addChild('Proposer', array('route' => 'proprietaire'));
            $menu->addChild('Comment ça marche', array('uri' => 'http://www.plateau-urbain.com/#!plate-forme/eqbhd', 'linkAttributes' => array('target' => '_blank')));
            $menu->addChild('Contact', array('uri' => '#footer'));
            $menu->addChild('S’inscrire', array('uri' => '#inline_register_content',  'linkAttributes' => array('class' => 'inline cboxElement')));
            $menu->addChild("Se connecter", array('uri' => '#inline_content', 'extras' => array('safe_label' => true), 'linkAttributes' => array('class' => 'inline cboxElement connectMenu')));
        }

       return $menu;
    }
}
