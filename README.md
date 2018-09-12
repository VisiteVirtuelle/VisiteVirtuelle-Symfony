# Visite Virtuelle Immobilière
Visite Virtuelle Immobilière est un projet du BTS SN option IR du [lycée Antoine Bourdelle] de Montauban.
L'objectif du projet consiste créer une application Web destinée aux Agences Immobilières en leur permettant de créer des visites en vue 360° qui peuvent être visité par leurs clients.

-----

## Installation détaillée

Les commandes ci-dessous sont à exécuter à la racine du projet:
1. Télécharger [PHP] 7.1 au moins et l'ajouter dans le PATH
2. Installer les dépendances :
    * Installer [composer] *(gestionnaire de dépendances)*:
        * Installation locale `php -r "readfile('https://getcomposer.org/installer');" | php`
        * [Installation globale]
    * Téléchargement des dépendances :
        * Composer est installé localement: `php composer.phar install`
        * Composer est installé gloabalement: `composer install`
3. Création de la base de données :
    * Création de la base de données `php bin/console doctrine:database:create`
    * Création des tables `php bin/console doctrine:schema:update --force`
4. Compilation des assets :
    * Installer [nodejs]
    * Télécharger [yarn] et l'ajouter dans le PATH
    * Exécuter `yarn install`
    * Compilation des assets avec `yarn run encore <env>` en remplaçant `<env>` par `dev` ou `production`

#### Commandes utiles :
* Chargement des données exemples/tests `php bin/console doctrine:fixtures:load`

-----

## Équipe
* Vincent CLAVEAU - *(Développeur Symfony)*
* Guillaume VIDAL - *(Développeur Symfony)*
* Valentin PILLON - *(Développeur ThreeJS)*
* Thomas DUDITLIEUX - *(Développeur ThreeJS)*
* Malko CARRERAS - *(Designer Web)*

## Organisation du projet
**Trello:** https://trello.com/b/lRY92q0W/organisation

[lycée Antoine Bourdelle]: http://bourdelle.entmip.fr/
[PHP]: http://php.net/downloads.php
[composer]: https://getcomposer.org/
[Installation globale]: https://getcomposer.org/download/
[nodejs]: https://nodejs.org/en/download/
[yarn]: https://yarnpkg.com/en/docs/install
