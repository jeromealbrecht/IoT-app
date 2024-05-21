# IoT-app

## Description
Ce projet est une application IoT (Internet of Things) développée pour gérer et surveiller des modules IoT. L'application est principalement écrite en PHP avec des éléments en JavaScript, CSS et Hack.

## Structure du projet

- **config/db** : Contient les configurations de la base de données.
- **includes** : Contient les fichiers d'inclusion pour l'application.
- **public** : Contient les fichiers accessibles publiquement.
- **src** : Contient le code source principal de l'application.
- **vendor** : Contient les dépendances et bibliothèques gérées par Composer.

## Fichiers principaux

- **.htAccess** : Fichier de configuration du serveur web.
- **README.md** : Ce fichier, fournissant des informations sur le projet.
- **add_module.php** : Script pour ajouter un module.
- **bdd_ioT_Jerome.sql** : Script SQL pour créer la base de données initiale.
- **bdd_ioT_Jerome_maj.sql** : Script SQL pour mettre à jour la base de données.
- **composer.json** : Fichier de configuration pour Composer.
- **composer.lock** : Fichier de verrouillage des dépendances pour Composer.
- **data.php** : Script pour gérer les données.
- **delete_module.php** : Script pour supprimer un module.
- **edit_module.php** : Script pour éditer un module.
- **export_pdf.php** : Script pour exporter des données en PDF.
- **generate_module_data.php** : Script pour générer des données de module.
- **get_module_status.php** : Script pour obtenir le statut d'un module.
- **index.php** : Point d'entrée principal de l'application.
- **module_status.php** : Script pour afficher le statut des modules.
- **modules.php** : Script pour gérer les modules.

## Installation

1. Clonez le dépôt :
    ```sh
    git clone https://github.com/jeromealbrecht/IoT-app.git
    ```

2. Accédez au répertoire du projet :
    ```sh
    cd IoT-app
    ```

3. Installez les dépendances avec Composer :
    ```sh
    composer install
    ```

4. Configurez la base de données en exécutant les scripts SQL dans le dossier `bdd_ioT_Jerome.sql` et `bdd_ioT_Jerome_maj.sql`.

5. Configurez vos paramètres de base de données dans le fichier de configuration approprié dans `config/db`.

## Utilisation

- Accédez à l'application via votre navigateur web en ouvrant le fichier `index.php`.
- Utilisez les différents scripts (e.g., `add_module.php`, `edit_module.php`, etc.) pour gérer vos modules IoT.

## Contribuer

1. Forkez le projet.
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`).
3. Commitez vos modifications (`git commit -m 'Add some AmazingFeature'`).
4. Poussez la branche (`git push origin feature/AmazingFeature`).
5. Ouvrez une Pull Request.

## Licence

Ce projet n'a pas de licence spécifiée.

## Auteurs

- [jeromealbrecht](https://github.com/jeromealbrecht)

Pour toute question ou aide supplémentaire, veuillez ouvrir une issue sur ce dépôt.
