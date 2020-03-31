www
===

A Symfony project created on June 2, 2015, 10:59 am.

Installation of `symfony34` branch
====================================

    git checkout symfony34_24eme
    composer install
    # Si composer install échoue, supprimer le fichier composer.lock et recommencer
    # Si la base de données existe déjà, passer les étapes de doctrine
    php app/console doctrine:database:create
    php app/console doctrine:schema:create
    php app/console hautelook:fixtures:load --purge-with-truncate -b AppBundle
    php app/console assets:install
    php app/console assetic:dump
    make


User admin
===========

    php app/console  fos:user:create admin admin@localhost pass_admin
    php app/console  fos:user:activate admin@localhost
    php app/console  fos:user:promote admin@localhost role_admin
