# Préambule

Bonjour et bienvenue dans la documentation du Cmf Synapse.

Pour commencer, enfonceons les portes ouvertes : aujourd'hui, nous déveleppons de moins en moins de sites webs, pour lequels les Cms historiques sont faits, au profits d'applications web, riches en interactions, règles de gestion et interconnexions auxquelles répondent parfaitement les frameworks.

Synapse a été développé avec en ligne de mire d'être une offre supplémentaire dans la jungle de projets Open Source de gestion de contenus; mais orientée projet métier, en combinant le meilleur des deux mondes :

 - Avoir à disposition des modules de gestion de contenu "classiques", des interfaces pré-construites, des modules plug-and-play, une gestion de médias etc...
 - Une base framework, permettant d'implémenter tout ce qui est possible en Php, grâce à Symfony

Cependant, comme dit l'adage, "there's no silver bullet" en informatique : le compromis sur lequel est basé Synapse oblige à ne prendre aucune décision métier autre que pour la gestion éditoriale, ce qui veut dire que plus de travail sera nécessaire pour compléter le projet.
La conséquence : il pourrait convenir à la création de simples vitrines, mais n'a aucune plus value dans ce domaine par rapport à d'autres solutions, plus légères installer et exploiter. Cependant, si la vitrine n'est que la première pierre d'un édifice beaucoup plus imposant comme par exemple un site e-commerce connecté à de nombreuses autre applications, c'est dans ce genre de cas que Synapse excelle.

Prenons maintenant le virage du sujet polémique avec l'affirmation habituelle, encore très ancrée dans les esprits : "Je ne veux pas réinventer la roue".
Cet adage est inadapté au web d'aujourd'hui, c'est un fait. Ne pas réinventer la roue signifie que nous allons toujours voir en premier si quelqu'un d'autre n'a pas produit et publié le travail que nous nous apprétons à commencer. Souvent, on trouve. Très souvent. Et quand on ne trouve pas, on trouve quelque chose qui ressemble. Alors une fois trouvée on l'utilise, voir on l'adapte. Mais à l'utilisation, la roue est faite dans un matériau peu robuste, ou alors se déforme dans les virages. Ce n'est pas la faute du mécanicien, c'est le besoin du pilote de prendre des virages serrés. Il ne serait pas pilote dans le cas contraire. Ce n'est pas non plus la faute du premier concepteur de roue : il a peut-être conçue sa roue bien avant que le pilote ne sache se servir d'un volant. Le soucis vient du postulat de départ : aucune roue ne pouvait être adaptée pour ce pilote.
Aujourd'hui sur le web, ceux qui réussissent sont ceux qui inventent, innovent, ceux qui ont un système de fonctionnement efficace, fiable. Qui ont la maîtrise de leur système d'information. Or, chaque module rendant un service métier inclu dans le système d'information est de la dette technique : si la société innove, le module ne sera plus adapté et devra être remplacé. Et souvent celà a un coût très important, qui plus est en cas de dépendance du reste du système.
Prenons maintenant du recul par rapport à cette affirmation : qu'en est-il si ce n'est pas seulement la roue, mais le véhicule entier qui n'a pas été inventé ? Tout est à potentiellement à refaire. Mais tant qu'on ne veut qu rouler en ville, aucun soucis. Mais de là à pouvoir rouler sur autoroute, parfois il y a un pas.

Et c'est ici que Synapse créée de la valeur : aucune roue n'est proposée, seulement les outils pour créer la votre. Celà prend du temps, de l'énergie de concevoir une roue. Mais cette roue sera adaptée au pilote.

Ici se referme l'éternel débat du "custom vs out-of-the-box".

Le second principe est en fait un corollaire du premier : si Synapse est conçu pour que les développeurs usent de leurs talents, leur proposer des APIs simples et efficaces, des middlewares, des configurations, des logs et outils de debug coule de source. Toutes ces notions, appelées "Developper experience", ou DX, sont déjà des priorités du framework Symfony.

Synapse dispose donc d'une interface peu intrusive avec le reste du projet, privilégiant systématiquement le découplage, au prix parfois de complexité supplémentaire, pour rester dans cette logique d'isolation pour éviter effet de bords et dépendances intempestives.

Pour conclure et résumer les points précédents, Synapse est orienté pour les déveleppeurs de projets dits "custom", qui ne veulent pas rentrer dans l'engrenage d'un système complet. Il convient à tous types de projets, en particulier aux applications à forte concentration de règles de gestion.


# Architecture et partis pris

Rentrons maintenant dans le détail : comment Synapse permet de disposer à la fois d'une gestion de contenu puissante mais sans couplage fort ?
En premier lieu, grâce à deux design patterns très utilisés actuellement, en particulier dans Symfony : Decorator (composant Templating) et Prototype (composant Form).
Et d'autre part, grâce à une application des principes SOLID, en particulier la maitrise des dépendances des objets.

Le modèle de Synapse découle de ces deux éléments d'architecture, détaillée dans les rubriques suivantes.

## Inversion de contrôle

Comme décrit plus haut, Synapse n'est pas intrusif dans le modèle du projet qui l'utilise.
Pour ce faire, une inversion de contrôle a été implémentée entre les objets métiers et le modèle de Synapse, à travers la notion de type de contenu.

Traditionellement, quand il est possible d'implémenter des modèles personalisés, la conséquence est l'inclusion en dûr de code de la librairie de gestion de contenu dans le modèle métier, soit par classes abstraites / héritage, soit par composition. Dans les deux cas, le modèle métier est lié à la librairie, de manière forte : des méthodes dédiées sont présentes dans les objets et de fait, l'architecture du projet est contrainte.

Synapse prend le contrepied de ces habitudes en s'affranchissant du lien fort avec l'objet métier : il n'interviendra jamais dessus directement, et se contentera de le décorer à l'aide de son propre modèle. L'objet décoré doit simplement implémenter une interface, puis être référencé dans une configuration (voir la [configuration des types de contenu]()).

Grâce à ces éléments, Synapse dispose de quoi abstraire n'importe quel objet métier derrière la notion de Contenu et de Type de Contenu, lien entre les modèles, comme l'illuste le diagramme de classes ci-dessous.

Il est donc possible de décorer n'importe quel objet métier grâce à Synapse, et ce sans corrompre son identité logicielle, allant d'une simple page web (comme dans la distribution [PageBundle]()), à un article de presse, en passant par un produit e-commerce avec de nombreuses dépendances.

## Diagramme de classes - Modèle d'entités

-- diagramme ici --

Le diagramme ci-dessus représente le modèle interne de Synapse, ainsi que ses intéraction avec les objets métiers du projet.

Quatres éléments importants se distinguent :

 - Les thèmes : namespace des éléments Synapse, chaque élément sous-jacent est toujours référencé à l'intérieur d'un thème. Physiquement, il correspond au bundle Symfony qui déclare le thème et les templates.
 - les templates : gabarits de pages, layout, coeur du pattern decorator, il est en particulier le template Twig dans lequel sera rendu le contenu, et est composé de zones.
 - les zones : espaces dans un template, déclarés via des tags similaires à des blocks Twig, dans lequelles il est possible d'ajouter et de rendre des composants.
 - les composants : éléments de décoration d'un contenu, ajoutés dans une zone et porteurs de données utilisables dans leur contexte de rendu seulement.

Ces éléments sont chacun adjoints d'un "type". Ces types sont créés depuis la configuration, le prototypage, des thèmes. Ils définissent les informations spécifiques au rendu d'un template, comme en particulier les templates Twig à appeler, les configurations par défaut, les composants autorisés pour telle ou telle zone, les formats d'images etc...

Le prototypage des ces éléments permet de disposer d'une grande flexibilité sur le modèle et le moteur de rendu de Synapse, sans pour autant écrire la moindre ligne de code Php : les développeurs en charge du front peuvent donc reprendre leurs droits sur le paramétrage de leurs rendus, et ainsi maitriser toute la chaine de décoration d'un contenu.


# Installation

A faire après la vendorisation du projet.



# Configuration du Cmf bundle

Le Cmf se configure comme n'importe quel bundle : via le fichier config.yml. Cependant, comme il s'agit d'un système complexe, nécessitant quelques dépendances, des configurations spécifiques sont à rajouter pour d'autres librairies comme Doctrine.

## Référence

Voici la liste exhausitve des configurations disponibles :
```yml
# app/config/config.yml

synapse_cmf:
  content_types:               # Synapse content types definitions
    F\Q\C\N\Content:             # full qualified class name of content type class
      alias: my_content            # content type alias into all other Synapse configurations
      provider: my_content_loader    # content provider class service id 

    # other content type definitions

  components:                   # Synapse component types definitions
    custom_component:             # alias of component type
      form: "F\Q\C\N\CustomType"    # full qualified class name of dedicated form type class

      controller: "Bundle:Controller:Action"  # Symfony-style controller signature for component front resolution

      template_path: "Bundle:folder:template.html.twig"  # default twig template for component rendering

      config:         # component default configurations will be injected as form type options
        key: value
        foo: bar

    # other component types definitions

  media:          # Synapse media configurations
    store:
      physical_path: "%kernel.root_dir%/../web/uploads"  # Physical path to media storage directory
      web_path: "/uploads"                               # Web path prefix for media directories

  forms:
    enabled: true   # enable or disable Synapse form registration 
                    # disable it if there's no need for a web admin for templates and skeletons
```

Pour plus de détail sur les impact de ces configurations, référencez vous aux chapitres dédiés sur [les types de contenus](), [les composants]() et [la médiathèque]().

D'autre part, Synapse utilise Doctrine pour gérer la persistence de son modèle, il doit donc également disposer de sa propre configuration de l'ORM. Une grande partie est définie dans les configurations par défaut (voir plus bas), cependant, il est tout de même nécessaire de définir soi-même la connection à utiliser; Synapse dispose de son propre entity manager, qui est paramétré par défaut sur la connection `synapse`.

Dès lors, il reste à définir la connection, comme suit :
```
doctrine:
  dbal:
    connections:
      default:
        # .......
      synapse:
        driver:   pdo_mysql
        host:     "%database_host%"
        port:     "%database_port%"
        dbname:   "%database_name%"
        user:     "%database_user%"
        password: "%database_password%"
        charset:  UTF8
    orm:
      default_entity_manager: default
```

Le choix d'implémenter un entity manager différent vient de la volonté de proposer :
  
 - flexibilité : Synapse requiert du MySQL, vous préférez PostgreSQL, c'est possible
 - isolation : le modèle Synapse étant isolé, même dans la persistence, ce qui garanti aucun effet de bord, jusqu'en base de données

La contrepartie d'un tel model est qu'il ne sera pas simple d'implémenter des relations entre le modèle métier et le modèle Synapse, comme dans le cas des images. Mais il peut être simple de contourner le soucis, comme présenté dans [cet article](cookbook.html).

## Configuration par défaut

Synapse requiert beaucoup de configuration, y compris dans des librairies externes, Doctrine en particulier. Dans le but de simplifier le paramétrage, un jeu de configurations par défaut est proposé par le bundle Cmf lui même, et est inclu par défaut.
Ces configurations sont rassemblées dans [ce fichier]().

### Cmf

Le premier bundle que configure Synapse est... lui même.
Dans le détail, il référence les types de composants natifs du framework : free, static, text, gallery et menu.

Les référencer de cette manière permet de le désactiver explicitement via la configuration de l'application de la manière suivante :
```yml
synapse_cmf:
  components:
    static: null      # désactive explicitement le composant "static"
    free: ~           # utilise la configuration par défaut dans son ensemble
    text:
      form: ~                                              # reconfigure le composant text en conservant
      controller: ~                                        # le formulaire et le controller natif
      template: "Bundle:folder:template.html.twig"         # mais en surchargeant le template par défaut
```
Note : les appels "~" dans le format Yaml sont optionnels, si une clé n'est pas définie, le même comportement s'opère en incluant la clé déjà définie, donc dans ce cas, la configuration par défaut.

### Doctrine

Comme vu plus haut, Synapse dispose de son propre entity manager, ce qui induit un petit peu de configuration, qui est inclue par défaut.

### Autres dépendances

Synapse requiert la librairie utilitaire MajoraFrameworkExtraBundle, en particulier pour ses helpers Doctrine, qu'il est nécessaire d'activer via configurations.

Enfin, l'excellent StofDoctrineExtensionBundle est également configuré par défaut, pour activer l'extension `timestampable` sur l'entity manager de Synapse.




# Types de contenus

Les types de contenus Synapse sont une abstraction du modèle métier du projet.
Comme toute abstraction, elle doit être "concrétisée", de préférence via une instanciation ou une configuration.

Les types de contenus sont donc déclarés via la configuration du bundle (voir la [référence]() ci dessus), de manière à les lier au modèle métier comme suit :
```yml
synapse_cmf:
  content_types:
    F/Q/C/N/MyCustomObject:
      alias: my_custom_object
      provider: service_id
```

Dans le détail, la clé de chaque type de contenu déclaré est le nom complet de la classe des objets de contenu.
Chacune de ces classes représentant un objet de contenu doit implémenter l'interface `Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface`, qui ne nécessite qu'une seule méthode : `getContentId()`.
```php
<?php

namespace src/Vendor/MyCustomContent/Component/Entity;

use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface as SynapseContent;

class MyCustomObject implements SynapseContent
{
    // ...

    public function getContentId()
    {
        return $this->id;
    }
}
```
L'identifiant de chacun des objets et nécessaire, car selon les cas, un template Synapse pourra être créé pour chaque objet métier, qu'il faudra donc associer via une valeur unique.


Chaque type de contenu est aliasé pour faciliter les autres configurations par la suite (celles des thèmes en particulier). Par ailleurs, celà autorise d'éventuelles modifications de modèle sans reprendre toutes les configurations et données de Synapse.



L'attribut "provider" quant à lui est un service capable de fournir un contenu à partir de son identifiant.
Ce service doit implémenter l'interface `Synapse\Cmf\Framework\Theme\Content\Provider\ContentProviderInterface`.

Exemple d'implémentation avec Doctrine Orm, dans le repository de l'entité :
```php
// src/Vendor/MyCustomContent/Component/Repository/OrmRepository.php

namespace Vendor/MyCustomContent/Component/Repository;

use Doctrine\ORM\EntityRepository;
use Synapse\Cmf\Framework\Theme\Content\Provider\ContentProviderInterface as SynapseContentProvider;

class OrmRepository extends EntityRepository implements SynapseContentProvider
{
  // ...

  public function retrieveContent($contentId)
  {
    return $this->createQueryBuilder('content')
      ->where('id = :id')
        ->setParameter('id', $contentId)
      ->getQuery()
        ->getOneOrNullResult()
    ;
  }
}

```


# Thèmes


# Templates


# Zones


# Composants


# Formulaires

