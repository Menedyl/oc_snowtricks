# oc_snowtricks

Le projet SNOWTRICKS à été conçu pour regrouper les internautes autour d'une même passion : le snowboard !

# Installation

Pour utiliser le projet vous devez vous assurer d'avoir accès au commandes PHP dans votre console.
 
Cloner le dêpot GitHub sur votre ordinateur et placer le dans votre répertoire web habituel.

Vous aurez besoin du composant "Composer", lancer la commande suivante dans la console : 
C:\wamp\www> php -r "eval('?>'.file_get_contents('http://getcomposer.org/installer'));" 
 
Utiliser la commande "php ../composer.phar update" pour mettre à jour toutes  les dépendances du projet.
 
Configurer le fichier "parameters.yml" pour renseigner vos paramètres de votre base de données.

Créer ensuite la table correspondante dans la base de donnée avec la commande : php bin/console doctrine:database:create

Générer ensuite les tables à l'intérieurs de cette base de données avec la commande : phpbin/console doctrine:schema:update --force

La commande "php bin/console app:create-all-fixtures" vous permettras de remplir les tables avec un jeux de données.
