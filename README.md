www
===

A Symfony project created on June 2, 2015, 10:59 am.

Installation of `symfony34` branch
====================================

    git checkout symfony34
    composer install
    php app/console assets:install
    php app/console assetic:dump


User admin
===========

    php app/console  fos:user:create admin admin@localhost pass_admin
    php app/console  fos:user:activate admin@localhost
    php app/console  fos:user:promote admin@localhost role_admin
