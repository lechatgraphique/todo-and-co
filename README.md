# ToDo & Co #
  
Projet OpenClassrooms : Améliorez une application existante de ToDo & Co
  
## Informations du projet ##
Projet de la formation ***Développeur d'application - PHP / Symfony***.  

## Installation
1. Clonez ou téléchargez le repository GitHub dans le dossier voulu :
```
    https://github.com/lechatgraphique/todo-and-co.git
```
2. Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier `.env`
.
3. Téléchargez et installez les dépendances du projet avec [Composer](https://getcomposer.org/download/) :
```
    composer install
```
4. Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
```
    bin/console doctrine:database:create
```
5. Créez les différentes tables de la base de données en appliquant les migrations :
```
    bin/console doctrine:migrations:migrate
```
6. (Optionnel) Installez les fixtures pour avoir une démo de données fictives :
```
    bin/console doctrine:fixtures:load
```
7. Félicitations le projet est installé correctement, vous pouvez désormais commencer à l'utiliser !
```
