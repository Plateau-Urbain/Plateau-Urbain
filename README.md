Plateforme d'appel à candidature
===

Prérequis
===

* Lesscss (`npm install -g less`)
* composer (`apt install composer` ou [getcomposer.org](https://getcomposer.org))

Installation
============

```sh
composer install # Si composer install échoue, supprimer le fichier composer.lock et recommencer

## BDD
# Si la base de données existe déjà, aller aux étapes d'assets
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console hautelook:fixtures:load --purge-with-truncate -b AppBundle

## Assets
php app/console assets:install
make # compilation less
php app/console assetic:dump
```


Création d'un user admin
========================

```sh
php app/console fos:user:create admin admin@localhost pass_admin
php app/console fos:user:activate admin@localhost
php app/console fos:user:promote admin@localhost role_admin
```
