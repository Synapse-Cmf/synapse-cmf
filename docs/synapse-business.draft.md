# Synapse

## What this ?
Synapse est un CMF, Content Management Framework, sous lincense MIT, basé sur la standard édition du framework Symfony.
100% compatible avec Symfony Standard Edition supérieur à la version 3, et tous les bundles communautaires qui suivent les bonnes pratiques, il permet d'implémenter une logique CMS autour de n'importe quel objet métier à un projet et ce en restant :
    
- non intrusif : utilisation de bundles, en ayant recours à un minimum d'évènements ou de surcharges pour éviter les effets de bord
- standard : le noyau est construit en suivant les patterns Decorator et Prototype, connus et reconnus par la majorité de la communauté
- flexible : utilise tout le potentiel des composants DependencyInjection, HttpKernel, ExpressionLanguage et Routing de Symfony
- léger : nécessite aucune autre ressources que le système de fichiers et 7 tables dans une base de données, et n'inclue que peu de librairies annexes à celles proposées par Symfony

## Why ?
Pourquoi encore un CM F/S ?
Parce qu'il reste encore une question sans réponse : comment implémenter une application Web évolutive stable et pérènne en Php, supportant beaucoup de règles métier personalisées, en utilisant un système de gestion de contenu Open Source ?

Synapse à vocation à répondre à cette question, en choisissant de proposer moins de features, mais de laisser une équipe de développeurs implémenter les règles propres à un projet, sans obfusquer une quelconque Api, ou surcharger des comportements standards.

Il repose sur deux axes principaux :

- inversion de contrôle : le couplage avec le projet ne se fait que via configuration et interfaces Php, Synapse est client du projet et non l'inverse, il s'inclue dans votre projet via Composer, vous ne créez pas votre projet dans une copie de Synapse
- developper experience : les fonctionnalités CMS sont souvent difficiles d'accès, tant en terme d'implémentation que de maintenance, Synapse est avant tout orienté en direction des développeurs, front et back, de manière à leur permettre d'exprimer leur expertise. Synapse s'inspire du Domain Driven Design, en particulier de la philosophie "Code First" pour proposer une Api programmatique épurée et simple, accessible depuis l'injection de dépendance


## Concepts et fonctionnalités

### Types de contenus
La notion centrale de Synapse est le "type de contenu", bien ancrée dans la plupart des Cms : il s'agit de l'abstraction d'un objet métier, celui propre au projet, dans le moteur de rendu. C'est l'objet qui sera décoré à la demande lors de l'appel à Synapse en front.
Selon les projets, les types de contenus peuvent aller du plus simple (une page web), au plus compliqué, comme un article à ajouter dans un panier. Grâce à cette abstraction, Synapse permet de décorer n'importe lequel des objets correspondant au plus près du métier de votre projet.

### Thème
La notion suivante est la notion de thème. Il se comporte comme un namespace pour les prototypes de templates, zones et composants. L'activation d'un thème est pilotée par le développeur qui peut choisir de l'activer sur une route précise, un domaine ou selon une condition personalisé.

#### Structure
Au sein d'un thème vient ensuite une structure bien connue pour les utilisateurs de CMS : template, zone et composant; un template active des zones, dans lesquelles sont rendu des composants.
Chacun possède une classe de prototype, définis par le designer / développeur front en fonction de la conception du front, par exemple : 

- un template de homepage avec :
    - une zone menu en haut de page, dans lequel on peut ajouter des composants "menu"
    - une zone principale, qui autorise tous les types de composants
    - une zone colonne de droite, avec les composants articles les plus vus / partagés
    - une zone footer, qui autorise lui aussi le composant menu, mais dans un habillage différent
- un template d'articles avec :
    - la même zone menu
    - une zone principale, autorisant un composant capable de rendre un article
    - une zone colonne de droite, avec les composants articles similaires, nuages de tags etc...
    - la même zone footer

Ce prototype de thème est ensuite instancié lors de l'appel aux classes de services, via appel direct, formulaires, ou autres selons les distributions, et persisté pour rendu ultérieur. A chaque template instancié, il doit être lié à à minima un type de contenu (il se comportera en template par défaut : un skeleton), ou à un type de contenu précis (l'article avec l'identifiant "42").

#### Rendu
Ce sytème de prototypage permet une très grande flexibilité, et repositionne le développeur front au coeur de la conception du rendu : il ne subit aucune ingérence de la librairie, il la pilote lui même. C'est lui qui prévoit tous les affichages possibles, de manière à ce qu'à aucun moment, une action éditoriale ne compromette l'intégrité de la page.
Il dispose également d'un outil puissant pour adapter son thème à des paramètres dynamiques, comme par exemple le user agent : les variations. Plutôt que dupliquer tout un prototype, et de demander au développeur back d'intervenir, le développeur front peut inclure des conditions de surcharge à tous ses éléments pour qu'il s'adapte dynamiquement, grâce au composant ExpressionLanguage.
Enfin, Synapse est totalement intégré à Twig, via le sytème d'extensions, ce qui permet au développeur front d'avoir à disposition les meilleurs outils et d'être totalement libre dans la sémantique, le markup, la gestion des assets etc...

#### Extensions
Le côté "Framework" de Synapse ne repose pas que sur la notion de types de contenu : les types de composants disponibles ne se limitent pas à ceux inclus par défaut, vous pouvez créer simplement tous ceux nécessaires à la décoration de vos types de contenus.

En reprenant l'exemple précédent, "Article" étant un type de contenu métier propre au projet, Synapse n'implémente pas les composants affichant des articles similaires. L'équipe back doit donc développer un composant dédié, que le développeur front va pouvoir ensuite référencer dans son prototype.
De même que pour les types de contenu, les composants se référencent via la configuration du Cmf, et sont ensuite utilisés via l'injection de dépendance de Symfony.

Grâce à ce système, en quelques lignes il est possible de brancher n'importe quel module de votre application à Synapse, et ce quelle que soit sa complexité, sans être intrusif : la configuration requise et le comportement sous-jacent sont les mêmes que pour un controller de l'édition standard de Symfony. Les composants sont exécutés puis rendus dans des sous-requêtes, de la même manière qu'une inclusion de controller, ce qui permet entre autre de maîtriser la variance de cache, et de profiter de l'implémentation des ESIs par Symfony.

Par défaut, Synapse propose 5 composants généralistes :

- Free : affichage d'une chaine de caractère échappée ou non, directement dans le template; utile pour inclure des widget Javascript, des tags de marquage Google Analytics, des vidéos exportées etc...
- Static : inclusion d'un template en dûr, le designer donne une liste de templates disponibles, et l'utilisateur en choisi un; utile par exemple pour modifier un logo à la volée lors d'une opération spéciale
- Text : composant principal d'affichage de texte, avec éditeur riche ou non, avec image ou non
- Gallery : composant d'affichage d'images sous forme de slider
- Menu *beta* : composant d'affichage de menus récursifs

### Médiathèque
Synapse inclue une gestion de médias simple et efficace, accessible elle aussi sous forme de services et de formulaires. Le module synchronise des fichiers et une persistance (base de données) pour permettre que les fichiers soient utilisés dans les autres composants de Synapse, comme la gallerie et le composant texte, ou tout autre module du projet.

*beta* Synapse ne gère pour l'instant que les images, mais le module sera étendu pour inclure rapidement tout type de fichier à télécharger depuis le front.

#### Images
Synapse propose une gestion améliorée des images : grâce à son module dédié, il met à disposition une fabrique de formats différents pour chaque image référencée. Ainsi, chaque image pourra être sélectionnée dans son état original, ou rogné selon le contexte d'utilisation, c'est la notion de formats.

L'utilisateur final de l'application pourra ainsi décliner ses images dans différents formats directement via Synapse, plutôt que de retoucher manuellement chaque image dans chacun des formats avant upload.

Le kernel du CMF est capable de piloter la gestion d'images en exposant la création des formats directement depuis les prototypes du thème : le designer / développeur front peut ainsi contraindre les tailles d'images en front selon un format précis pour chaque composant, et utiliser les images déclinées directement depuis le template. Synapse utilisera systématiquement le bon format si défini.

Le module d'image permet donc de manipuler sans crainte les images en front, sans crainte de déteriorer l'agencement du site Web.

## Distributions
Synapse dispose de quatre distributions, à utiliser en fonction des besoins du projet :

- CmfBundle : bundle "kernel", expose la librairie. Distribution minimale de Synapse, aucun écran, aucune implémentation concrète de type de contenu n'est proposé.
    - Librairie de base du Cmf (services, entités, modèle etc...)
    - Features :
        - Moteur de rendu
        - Api programmatique du modèle Synapse (thèmes, templates, composants etc...)
            - Services
            - Formulaires
        - Module médiathèque

- AdminBundle : bundle backoffice, construit des interfaces aux fonctionnalités proposeés par le CmfBundle, habillées en suivant un thème Bootstrap
    - Thème de backend, avec layout global compilable via Sass et Gulp
    - Features :
        - Formulaires de création / édition des skeletons
        - Thème de formulaire d'édition de templates
        - Interface du module médiathèque
    - Requiert CmfBundle

- PageBundle : implémente le type de contenu page, ainsi que son backoffice.
    - Features :
        - Type de contenu Page (rendu front et module d'admin)
        - Arborescence
        - Gestion des urls, des métas
        - Intégration à l'AdminBundle
        - Intégration du formulaire de template
    - Requiert AdminBundle

- Standard edition : installation d'un projet standard Symfony, avec une préconfiguration du thème de démonstration de Synapse
    - Feature :
        - Thème de démonstration
        - Configurations
        - Fonctionne out of the box
    - Requiert PageBundle
