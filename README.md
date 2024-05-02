# Système de réservation d**e salles : eReserv**

![Untitled](https://prod-files-secure.s3.us-west-2.amazonaws.com/69f3b78e-f6a9-4c4e-bdda-88148b92808f/26f5ae85-ae87-4dda-a63f-de15cf5d25ef/Untitled.png)

![Untitled](https://prod-files-secure.s3.us-west-2.amazonaws.com/69f3b78e-f6a9-4c4e-bdda-88148b92808f/09b05bcd-9542-4f84-b52d-66bbf2cb9f65/Untitled.png)

![Untitled](https://prod-files-secure.s3.us-west-2.amazonaws.com/69f3b78e-f6a9-4c4e-bdda-88148b92808f/a0cec114-94f0-45a7-96be-4a2a035c81a8/Untitled.png)

![Untitled](https://prod-files-secure.s3.us-west-2.amazonaws.com/69f3b78e-f6a9-4c4e-bdda-88148b92808f/d4ae198d-4fb8-48e0-b120-5dd1e75cef51/Untitled.png)

## **Introduction**

Le présent rapport décrit le développement d'un système de réservation de salle conçu pour permettre aux utilisateurs de réserver des salles pour des événements. L'objectif principal de ce projet est de fournir une plateforme conviviale et efficace permettant aux utilisateurs de vérifier la disponibilité des salles, de sélectionner une salle appropriée et de procéder à la réservation pour leur événement.

Ce système a été développé en utilisant une combinaison de technologies web, notamment PHP pour la gestion côté serveur, JavaScript pour les fonctionnalités interactives et CSS pour le style. La base de données MySQL a été utilisée pour stocker les informations sur les utilisateurs, les salles et les réservations.

Le rapport suivant détaillera les différentes phases de développement du système, notamment la conception de la base de données, le développement de l'interface utilisateur, l'implémentation de la logique métier, les tests et le déploiement. Des détails sur les fonctionnalités clés et les défis rencontrés seront également discutés.

Ce système de réservation de salle offre une solution pratique et flexible pour gérer les réservations d'événements, en offrant aux utilisateurs une expérience fluide et intuitive lors de la recherche et de la réservation de salles.

## **Contexte**

La nécessité d'un système de réservation de salle découle des défis rencontrés dans la gestion manuelle des réservations d'événements. Les processus traditionnels basés sur des documents papier ou des systèmes de réservation obsolètes peuvent être inefficaces et sujets à des erreurs. Un système informatisé permettra une gestion plus efficace, réduira les risques d'erreurs et offrira une meilleure expérience utilisateur.

## **Les exigences**

Les exigences du système de réservation de salle sont les suivantes :

- **Gestion des utilisateurs :** Le système doit permettre aux utilisateurs de se connecter et l’utilisateur principale, l’administrateur pourra ajouter les autres utilisateurs, gérant ainsi les utilisateurs.
- **Gestion des salles :** Les salles disponibles doivent être répertoriées avec des détails tels que la capacité, les équipements disponibles et les photos.
- **Recherche de salle :** Les utilisateurs doivent pouvoir rechercher des salles disponibles en fonction de critères tels que la date, l'heure, la capacité et les équipements.
- **Réservation de salle :** Les utilisateurs doivent pouvoir sélectionner une salle disponible et effectuer une réservation pour une date et une heure spécifiques.
- **Confirmation de réservation :** Les utilisateurs doivent recevoir une confirmation de leur réservation par e-mail ou via l'interface utilisateur.
- **Gestion des réservations :** Les administrateurs doivent pouvoir consulter, modifier ou annuler les réservations existantes.
- **Interface utilisateur conviviale :** L'interface utilisateur doit être intuitive et conviviale, offrant une expérience utilisateur agréable.
- **Sécurité :** Le système doit garantir la sécurité des données des utilisateurs et empêcher tout accès non autorisé.

## **Modélisation**

La modélisation du système de réservation de salle repose sur la conception d'une base de données relationnelle qui permet de stocker et de gérer efficacement les informations sur les utilisateurs, les salles et les réservations. Voici une description de la modélisation proposée :

### **Entités principales :**

1. **Utilisateur :** Représente les utilisateurs du système.
    - Attributs : ID utilisateur, nom, adresse e-mail, mot de passe, rôle (utilisateur ou administrateur).
2. **Salle :** Représente les salles disponibles pour la réservation.
    - Attributs : ID de la salle, nom, capacité, équipements, photo.
3. **Réservation :** Représente les réservations effectuées par les utilisateurs.
    - Attributs : ID de réservation, ID de l'utilisateur, ID de la salle, date et heure de début, date et heure de fin.

### Diagramme de classes

![Untitled](https://prod-files-secure.s3.us-west-2.amazonaws.com/69f3b78e-f6a9-4c4e-bdda-88148b92808f/818705d0-8934-4f95-99bb-94172528b43b/Untitled.png)

**Relations :**

1. **Utilisateur - Réservation :** Relation un-à-plusieurs entre les utilisateurs et les réservations.
    - Un utilisateur peut gérer les plusieurs réservations,
    - Un utilisateur peut gérer les différentes salles
2. **Salle - Réservation :** Relation un-à-plusieurs entre les salles et les réservations.
    - Une salle peut être réservée pour plusieurs événements, mais chaque réservation concerne une seule salle.

**Schéma de la base de données :**

```
Utilisateur (UserID, Nom, Email, MotDePasse, Role)
Salle (SalleID, Nom, Capacite, Equipements, Photo)
Reservation (ReservationID, UserID, SalleID, Debut, Fin)
```

Cette modélisation permet de capturer efficacement les relations entre les utilisateurs, les salles et les réservations, tout en fournissant une structure de données flexible et extensible pour le système de réservation de salle. Elle servira de fondement pour le développement de la base de données et la mise en œuvre de la logique métier du système.

### Schéma de la base de données

Voici un exemple de schéma SQL pour une base de données simple pour le système de réservation de salle, comprenant des tables pour les utilisateurs, les salles et les réservations :

```sql
sqlCopy code
-- Table des utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('gestionnaire', 'administrateur') NOT NULL DEFAULT 'gestionnaire'
);

-- Table des salles
CREATE TABLE salles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    capacite INT NOT NULL,
    equipements TEXT,
    photo VARCHAR(255)
);

-- Table des réservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    salle_id INT NOT NULL,
    debut DATETIME NOT NULL,
    fin DATETIME NOT NULL,
    description TEXT,
    FOREIGN KEY (salle_id) REFERENCES salles(id)
);
```

Ce schéma définit trois tables découlant donc de nos trois classes :

1. **utilisateurs :** Stocke les informations sur les utilisateurs du système, y compris leur nom, leur email, leur mot de passe (haché) et leur rôle (utilisateur ou administrateur).
2. **salles :** Stocke les informations sur les salles disponibles pour la réservation, telles que leur nom, leur capacité, les équipements disponibles et une référence à une photo.
3. **reservations :** Stocke les informations sur les réservations effectuées, l'identifiant de la salle réservée, les dates de début et de fin de la réservation, ainsi qu'une description facultative.

### Structure du projet

## **Les tests effectués**

- **Tests unitaires :** Des tests unitaires ont été mis en place pour vérifier le bon fonctionnement des différentes parties du système de manière isolée, en s'assurant que chaque fonctionnalité individuelle répond aux spécifications requises.
    
    Pour mettre en place des tests unitaires pour le système de réservation de salle, nous avons utilisé un framework de test unitaire, PHPUnit. 
    
    Ci-dessous nous avons une illustration du test effectué pour tester la fonction de création d’un compte utilisateur et celle de l’authentification d’une utilisateur au système :
    
    ```php
    
    <?php
    use PHPUnit\Framework\TestCase;
    
    class UtilisateurTest extends TestCase {
        public function testEnregistrerUtilisateur() {
            // Création d'un utilisateur
            
            $data['name'] = "John Doe";
            $data['username']= "johndoe";
            $data['password'] = "123456789";
            $data['role'] = "administrateur";
    
            // Enregistrement de l'utilisateur
            $resultat = User::create($data);
    
            // Vérification du résultat
            $this->assertTrue($resultat);
        }
        
        public function testAuthentifierUtilisateur() {
            // authentification  d'un utilisateur
            $data['username']= "johndoe";
            $data['password'] = "123456789";
    
            // Authentification de l'utilisateur
            $resultat = User::log();
    
            // Vérification du résultat
            $this->assertTrue($resultat);
        }
    }
    ?>
    ```
    
    Nous avons aussi fait de même pour la création des salles, la vérification de la disponibilité d’une salle et aussi l’ajout d’une réservation et la confirmation d’une réservation
    
- **Tests d'intégration :** Nous avons également pu commencer, sans toutes fois les avoir tous terminés à ce stade, les tests d’intégration pour évaluer la manière dont les différents modules du système interagissent les uns avec les autres.

## **Les leçons apprises et les recommandations**

Ce projet de développement d'un système de réservation de salle a permis d'apprendre plusieurs leçons importantes et de formuler des recommandations pour les projets futurs :

- **Planification minutieuse :** La planification détaillée du projet, y compris l'identification des exigences, la conception de la base de données et la définition des fonctionnalités, est cruciale pour garantir le succès du projet.
- **Test unitaire robuste :** L'importance des tests unitaires solides ne peut être surestimée. Les tests unitaires permettent de détecter les erreurs et les bogues dès le début du processus de développement, ce qui contribue à la stabilité et à la fiabilité du système.
- **Flexibilité et évolutivité :** Les systèmes de réservation de salle doivent être conçus avec une architecture flexible et évolutive pour s'adapter aux besoins changeants des utilisateurs et des entreprises. Il est important de prévoir des fonctionnalités d'extension et de personnalisation pour répondre aux exigences futures.
- **Expérience utilisateur :** L'interface utilisateur joue un rôle crucial dans la satisfaction des utilisateurs. Il est essentiel de concevoir une interface intuitive et conviviale qui facilite la recherche, la réservation et la gestion des salles pour les utilisateurs.

Nous recommandons : 

- Effectuer une analyse approfondie des besoins des utilisateurs et des exigences du projet avant de commencer le développement; ce rapprocher des promoteurs d’événements et des managers de salles serait utile à cela.
- Mettre en place des pratiques de développement agile pour permettre une adaptation continue aux besoins changeants.
- Prioriser la qualité du code en utilisant des tests unitaires, en documentant le code et en suivant les bonnes pratiques de programmation.
- Impliquer les utilisateurs finaux à chaque étape du processus de développement pour garantir que le système répond à leurs besoins et à leurs attentes.

## Conclusion

Le développement du système de réservation de salle a été une expérience enrichissante, permettant de mettre en pratique divers concepts et techniques de développement logiciel. En suivant une approche méthodique et en utilisant les meilleures pratiques de développement, nous avons réussi à créer un système fonctionnel et fiable pour la réservation de salles d'événements.

Ce projet a démontré l'importance de la planification minutieuse, efficace et de l'engagement envers la qualité et la satisfaction de l'utilisateur. En tirant parti des leçons apprises et des recommandations formulées, nous sommes bien équipés pour entreprendre des projets similaires à l'avenir et pour continuer à fournir des solutions logicielles de haute qualité, et voire même essayer de concrétiser de ce projet.

## Lien de l’application

https://ereserv.online/
https://ereserv.online/login

## Lien du github

https://github.com/houdini90/ereserv

## Manuel d’installation et de configuration

## Manuel d’utilisation
