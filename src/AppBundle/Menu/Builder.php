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

        $menu = $factory->createItem('root', array('childrenAttributes'=> array('class'=> 'nav navbar-nav',)));

        $Menu = $menu->addChild('La Coopérative', array('uri' => '#', 'attributes' => array('class'=>'dropdown menu-icon'), 'extras' => array(
            'safe_label' => true
        ),'linkAttributes' => array('data-toggle' => 'dropdown', 'data-hover' => 'dropdown')));
        $Menu->setChildrenAttribute('class', 'dropdown-menu');
        $Menu->addChild('Qui sommes-nous', array('uri' => 'https://staging.plateau-urbain.com/la-cooperative/', 'linkAttributes' => array('target' => '_blank')));
        $Menu->addChild("Devenir sociétaire", array('uri' => 'https://staging.plateau-urbain.com/devenir-societaire/', 'linkAttributes' => array('target' => '_top')));
        $Menu->addChild("Les équipes", array('uri' => 'https://staging.plateau-urbain.com/les-equipes/', 'linkAttributes' => array('target' => '_top')));
        $Menu->addChild("Ressources", array('uri' => 'https://staging.plateau-urbain.com/ressources/', 'linkAttributes' => array('target' => '_top')));
####
        $Menu = $menu->addChild('Notre offre', array('uri' => '#', 'attributes' => array('class'=>'dropdown'), 'extras' => array(
            'safe_label' => true
        ),'linkAttributes' => array('data-toggle' => 'dropdown', 'data-hover' => 'dropdown')));
        $Menu->setChildrenAttribute('class', 'dropdown-menu');
        $Menu->addChild("Notre accompagnement", array('uri' => 'https://staging.plateau-urbain.com/notre-offre/', 'linkAttributes' => array('target' => '_blank')));
        $Menu->addChild("Conseil et études", array('uri' => 'https://staging.plateau-urbain.com/conseil-et-etudes/', 'linkAttributes' => array('target' => '_blank')));
        $Menu->addChild("Montage et gestion", array('uri' => 'https://staging.plateau-urbain.com/montage-et-gestion/', 'linkAttributes' => array('target' => '_blank')));
        $Menu->addChild("Plateforme propriétaire", array('uri' => 'https://staging.plateau-urbain.com/plateforme/', 'linkAttributes' => array('target' => '_blank')));
        $Menu->addChild("Privatisation", array('uri' => 'https://staging.plateau-urbain.com/privatisation/', 'linkAttributes' => array('target' => '_blank')));
        ####
        $Menu = $menu->addChild('Les tiers-lieux', array('uri' => '#', 'attributes' => array('class'=>'dropdown'), 'extras' => array(
            'safe_label' => true
        ),'linkAttributes' => array('data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'class'=>'subarrow')));
        $Menu->setChildrenAttribute('class', 'dropdown-menu');
        $Menu->addChild("Nos projets", array('uri' => 'https://staging.plateau-urbain.com/nos-projets/', 'linkAttributes' => array('target' => '_top')));
        $Menu->addChild("Actualités des lieux", array('uri' => 'https://staging.plateau-urbain.com/actualites-des-lieux/', 'linkAttributes' => array('target' => '_top')));
        $Menu->addChild("Occupant·es", array('uri' => 'https://staging.plateau-urbain.com/occupant-es/', 'linkAttributes' => array('target' => '_top')));
        $menu->addChild('Trouver un local', array('route' => 'search_index','attributes' => array(
            'class' => 'local',
        )))->setLabel('<span class="sub-arrow">Trouver un local</span>')->setExtra('safe_label',true);
        ####
        if ($isLogged) {

            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $context = $this->container->get('security.authorization_checker');

/*            if ($user->isProprio() || $context->isGranted('ROLE_OWNER')) {
                $menu->addChild('Proposer un espace', array('route' => 'space_manager_add'));
            }*/
/*            if ($user->isPorteur() || $context->isGranted('ROLE_PROJECT_HOLDER')) {
                $menu->addChild('Trouver un local', array('route' => 'search_index'));
            }*/
            $loggedMenu = $menu->addChild('Mon compte', array('uri' => '#', 'attributes' => array('class'=>'dropdown'), 'extras' => array(
                'safe_label' => true
            ),'linkAttributes' => array('data-toggle' => 'dropdown', 'data-hover' => 'dropdown')));
            $loggedMenu->setChildrenAttribute('class', 'dropdown-menu');

            $loggedMenu->addChild('Mon profil', array('route' => 'security_profil', 'attributes' => array('class'=>'')));

            if ($user->isProprio() || $context->isGranted('ROLE_OWNER')) {
              $loggedMenu->addChild('Mes espaces', array('route' => 'space_manager_list', 'attributes' => array('class'=>'')));
              $loggedMenu->addChild('Ajouter un espace', array('route' => 'space_manager_add', 'attributes' => array('class'=>'')));

              $loggedMenu->addChild('Liste des AACs', ['route' => 'aac_list', 'attributes' => ['class' => '']]);
            } else if ($user->isPorteur() || $context->isGranted('ROLE_PROJECT_HOLDER')) {
              $loggedMenu->addChild('Mes candidatures', array('route' => 'my_applications_list', 'attributes' => array('class'=>'')));
            }

            $loggedMenu->addChild('Déconnexion', array('route' => 'fos_user_security_logout', 'attributes' => array('class'=>'off-icon menu-icon')));

        } else {

            #$menu->addChild('Proposer', array('route' => 'proprietaire'));
            /*$menu->addChild('Trouver un local', array('route' => 'search_index', 'attributes' => array('class'=>'local')));*/
            $menu->addChild('Trouver un local', array('route' => 'search_index','attributes' => array(
                'class' => 'local',
            )))->setLabel('<span class="sub-arrow">Trouver un local</span>')->setExtra('safe_label',true);
            /*$menu['Trouver un local']->setLabel('<span class="sub-arrow"></span>')->setExtra('safe_label',true);*/
            $menu->addChild("Se connecter", array('uri' => '#inline_content', 'extras' => array('safe_label' => true), 'linkAttributes' => array('class' => 'inline cboxElement connectMenu')));
        }

       return $menu;
    }
}
