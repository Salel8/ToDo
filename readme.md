# ToDo & Co

Ce projet, réalisé avec PHP/Symfony, est un site web permettant de créer et de modifier des utilisateurs ainsi que de créer et de modifier des tâches. Le site web dispose d'un système d'authentification ainsi qu'une base de données qui stocke des données sur les utilisateurs et sur les tâches. Le but de ce projet est de réaliser des tests unitaires et des tests fonctionnels. Les fichiers du projet ont été récupérés dans un autre repository puis mis à jour, passant de la version de Symfony 3.2 à Symfony 7.0. Ensuite, quelques ajouts ont été réalisés. Les tests ont été réalisés avant de reprendre le site web, en Test Driven.

## Pré-requis

```php
PHP
Symfony
Git
Composer
Base de données MySQL
```

## Installation

Appuyez sur le bouton "Code" en vert, situé en haut de cette page. Choisissez entre HTTPS et SSH et copiez le nom du clone qui s'affiche. Créez un dossier où vous placerez le code du projet et ouvrez une fenêtre du terminal. Placez-vous dans ce dossier créé et clonez alors ce repository avec, par exemple en SSH, la commande git clone :

```bash
git clone git@github.com:Salel8/ToDo.git
```

Vous avez maintenant tout le projet en local mais avant de pouvoir l'utiliser, il vous faut créer votre base de données. Vous pouvez utiliser PHPMyAdmin pour créer votre base de données.

Pour cela, il vous faut créez un fichier .env.local et dans ce fichier il vous faudra insérer ce qui suit :

```php
DRIVER="driver"
DBNAME="dbname"
PORT=0000
USER="user"
PASSWORD="password"
HOST="host"
```

Veillez à bien modifier les champs "driver", "dbname", le port, "user", "password" et "host" avec ceux correspondant à votre base de données. Pour créer la base de données, son nom pourrait être "todo". En local, le driver est pdo_mysql, le dbname serait todo, le port est 8889, le host est 127.0.0.1, quand au user et au password il s'agit de ceux utilisé dans votre configuration PHPMyAdmin. Soit :

```php
DRIVER="pdo_mysql"
DBNAME="todo"
PORT="8889"
USER="user"
PASSWORD="password"
HOST="127.0.0.1"
```

Une fois que le fichier .env.local est configuré, il faut créer la base de données avec la commande :

```bash
php bin/console doctrine:database:create
```

Si par la suite vous voulez ajouter des modifications au niveau des entités du projet pour modifier les tables de la base de donnée, il faudra alors utiliser les commandes suivantes :

```bash
php bin/console make:migration
```

```bash
php bin/console doctrine:migrations:migrate
```

Enfin, lors des tests il est préférable de ne pas modifier la base de données. Nous pouvons alors créer une base de données qui ne servira qu'en environnement de test. Pour cela, il faut ajouter ce qui suit dans le fichier .env.test (comme nous l'avons fait précemment) :

```php
DRIVER="pdo_mysql"
DBNAME="todo"
PORT="8889"
USER="user"
PASSWORD="password"
HOST="127.0.0.1"
```

Puis, dans le fichier 'config/packages/doctrine.yaml', il faut ajouter :

```php
when@test:
    doctrine:
        dbal:
            # "TEST_TOKEN" is typically set by ParaTest
            dbname_suffix: '_test%env(default::TEST_TOKEN)%'
```

Enfin, il faut créer la base de données et ajouter les tables avec les commandes suivantes :

```php
symfony console doctrine:database:create --env=test
```

```php
symfony console doctrine:migrations:migrate -n --env=test
```

Cette configuration étant établie, vous pouvez dorénavant profiter pleinement de l'ensemble du projet.

## Démarrage

Pour lancer le projet, il faut commencer par installer toutes les dépendances du projet. Pour cela, lancez le serveur PHP puis, via le terminal, placez-vous dans le dossier créé plus tôt contenant le code du projet. Puis lancez la commande :

```bash
composer install
```
Cette commande permet d'installer toutes les dépendances liées à composer.

Votre base de données étant créée et configurée, il vous faut pré-charger des données grâce aux fixtures. Les fixtures sont déjà créées dans le fichier 'AppFixtures.php' qui se trouve dans le dossier 'src' puis dans le dossier 'DataFixtures'. Si vous voulez ajouter d'autres fixtures vous le pouvez le faire dans ce fichier.

Pour cela, il vous faut utiliser la commande terminale (toujours à la racine de votre projet) :

```bash
php bin/console doctrine:fixtures:load
```

Nous devons aussi charger les fixtures pour l'environnement de test dans la base de données de test avec la commande suivante :

```bash
symfony console doctrine:fixtures:load --env=test
```

Une fois cette commande réalisée, vous devez lancer le serveur de symfony avec la commande :

```bash
symfony server:start
```

Puis, ouvrez votre navigateur et allez sur la page  [http://localhost:8000/](http://localhost:8000/) pour vous rendre sur la page d'accueil du site web.


## Fabriqué avec 

HTML - CSS - Twig

PHP - Symfony

PHPMyAdmin - MySQL

Git - Composer

VSCode

## Versions

PHP 8.2.10

Symfony 7.0

## Auteur

Samir Mehal