# Visite Virtuelle Immobilière
Visite Virtuelle Immobilière est un projet du BTS SN option IR du [lycée Antoine Bourdelle] de Montauban.
L'objectif du projet consiste créer une application Web destinée aux Agences Immobilières en leur permettant de créer des visites en vue 360° qui peuvent être visité par leurs clients.

-----

## Installation
1. S'assurer que PHP est bien installé/présent dans le PATH avec `php -V`
2. Installer les dépendances :
   * Téléchargement de composer `php -r "readfile('https://getcomposer.org/installer');" | php`
   * Installation des dépendances `php composer.phar install`
3. Création de la base de données **(optionnel si déjà existante)** :
   * Création de la base de données `php bin/console doctrine:database:create`
   * Création des tables `php bin/console doctrine:schema:update --force`
#### Commandes utiles :
* Chargement des données exemples/tests `php bin/console doctrine:fixtures:load`

-----

## Équipe
* Vincent CLAVEAU - *(Développeur Symfony)*
* Guillaume VIDAL - *(Développeur Symfony)*
* Valentin PILLON - *(Développeur ThreeJS)*
* Thomas DUDITLIEUX - *Développeur ThreeJS)*
* Malko CARRERAS - *(Web Designer)*

## Organisation du projet
**Trello:** https://trello.com/b/lRY92q0W/organisation

[lycée Antoine Bourdelle]: http://bourdelle.entmip.fr/
