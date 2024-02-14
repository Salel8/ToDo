# ToDo & Co

## Avant de contribuer au projet

Si vous voulez contribuer au projet, améliorer le site web de ToDo & Co, vous êtes au bon endroit.

Premièrement, il vous faut récupérer le projet à l'adresse suivante :

```bash
https://github.com/Salel8/ToDo
```

Suivez le Readme du repository pour installer le projet en local. Une fois fait, vous pouvez dorénavant ajouter des fonctionnalités.

## Pour contribuer au projet

### Ajouter des données dans la base de données

Pour ajouter des données aux tables de la base de données, il vous faut modifier les entités qui se trouvent dans le dossier 'src' puis dans le dossier 'Entity'. Vous pouvez ajouter des propriétés et n'oubliez pas d'ajouter les méthodes correspondants à chaque propriétés (getter et setter).

Vous pouvez aussi ajouter des tables dans la base de données. Pour cela, à la racine du projet, utilisez la commande terminale suivante :

```bash
php bin/console make:entity
```

Vous devez suivre les étapes affichées dans le terminal pour créer des propriétés et méthodes (getter et setter). Vous pouvez en rajouter aussi manuellement comme vu plus haut. Si vous avez besoin d'aide, vous pouvez vous aider de la [documentation officielle de Symfony sur Doctrine](https://symfony.com/doc/current/doctrine.html#validating-objects).

### Ajouter des fonctionnalités

Pour ajouter des fonctionnalités, il faut modifier les contrôleurs qui se trouvent dans le dossier 'src' puis dans le dossier 'Controller'. Vous pouvez modifier les contrôleurs existant en ajoutant des fonctionnalités ou bien créer de nouveaux contrôleur avec la commande suivante :

```bash
php bin/console make:controller
```

Une fois que le contrôleur est créé, vous pouvez ajouter des fonctions, une par route, et écrire du code à l'intérieur.

### Ajouter des formulaires

Pour ajouter un formulaire, il faut vous rendre dans le dossier 'src' puis dans le dossier 'Form' et créer un fichier en .php. Ensuite, vous pouvez remplir votre fichier avec les fonctions permettant d'écrire des formulaires. Si vous avez besoin d'aide, vous pouvez suivre la [documentation officielle de Symfony sur les formulaires](https://symfony.com/doc/current/templates.html). Cependant, la bonne pratique consiste à créer le formulaire dans un fichier à part, par exemple 'exempleType.php', à placer dans le dossier 'Form' qui se trouve dans le dossier 'src'. Dans ce projet, il n'est pas convenable de créer un formulaire directement dans un contrôleur. Il est possible de le faire mais ce n'est pas la bonne pratique à adopter pour ce projet.

### Ajouter des templates

Pour ajouter des templates, il faut ajouter des fichiers Twig comme 'exemple.html.twig' dans le dossier 'templates'. Vous pouvez aussi créer des sous dossiers dans le dossier 'templates' pour avoir un sous dossier par contrôleur mais il ne faudra pas oublier le sous dossier dans le chemin de la vue (dans la fonction render()).

Les templates utilisent une base commune qui se trouvent dans le fichier base.html.twig. Il faut l'utiliser comme base pour ne pas à avoir à tout réécrire. Suivez la [documentation officielle de Symfony sur les templates](https://symfony.com/doc/current/templates.html), si vous avez besoin d'aide écrire votre template.

Vous pouvez également modifier les fichiers existants si vous voulez ajouter des modifications. Il faut cependant toujours vérifier que nous ne modifions rien de compromettant pour le site web et il faut garder la bonne pratique d'un fichier de template par page.

Vous pouvez également ajouter ou modifier des fichiers CSS de la même manière que pour les templates, dans le dossier 'css' qui se trouve dans le dossier 'public'. Dans le template, il faut ajouter le fichier avec, par exemple, le chemin 'css/exemple.css'.

Vous pouvez aussi ajouter ou modifier des fichiers JavaScript de la même manière que pour les templates ou pour les fichiers CSS, dans le dossier 'js' qui se trouve dans le dossier 'public'. Dans le template, il faut ajouter le fichier avec, par exemple, le chemin 'js/exemple.js'.

Enfin, vous pouvez ajouter des images, dans le dossier 'img' qui se trouve dans le dossier 'public'. Dans le template, il faut ajouter le fichier avec, par exemple, le chemin 'img/exemple.png'.

## Partager les modifications

Pour partager les modifications, il faut créer une nouvelle branche sur le repository du projet qui se trouve sur Github. Puis, il faut pusher l'ensemble du dossier contenant tous les fichiers du projet. Ensuite, il faut créer une pull-request entre la branche créée et la branche 'main'. La pull-request va analyser et comparer le code des deux branches. Enfin, s'il n'y a pas de conflit, vous pourrez alors merger la nouvelle branche à la branche 'main'.

Cette dernière étape étant faite, vous avez désormais contribué au projet avec vos ajouts et/ou vos modifications.

## Auteur

Samir Mehal