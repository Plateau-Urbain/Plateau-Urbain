www
===

A Symfony project created on June 2, 2015, 10:59 am.

Installation
============
    À ce stade du code pour déployer il faut : 
     - utiliser la version 2.2.9 de composer (problème avec sensio/distribution-bundle)
     - ajouter composer require laminas/laminas-zendframework-bridge
    composer install
    # Si composer install échoue, supprimer le fichier composer.lock et recommencer
    # Si la base de données existe déjà, aller aux étapes d'assets
    php app/console doctrine:database:create
    php app/console doctrine:schema:create
    php app/console hautelook:fixtures:load --purge-with-truncate -b AppBundle
    php app/console assets:install
    make
    php app/console assetic:dump


User admin
===========

    php app/console  fos:user:create admin admin@localhost pass_admin
    php app/console  fos:user:activate admin@localhost
    php app/console  fos:user:promote admin@localhost role_admin
