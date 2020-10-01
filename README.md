# Dùralas
[Dùralas](http://www.lemondededuralas.org/) est un forum français de rôle-play dans un univers médiéval-fantastique. Le principe est d'écrire des récits mettant en scène son propre personnage afin d'interagir avec d'autres joueurs.

## Administratif

Divers fonctionnements RP nécessite une administration de la part des maîtres du Jeu sur plusieurs domaines : commerce, artisanat, combat, etc.

Des messages récapitulatifs mis en forme sont postés par les gestionnaires RP comme Le Marchand ou Le Juge. Ces messages peuvent indiquer des résultats de calcul (notamment pour le commerce) et avoir trait à source d'erreur.

### Outils d'aide

Afin de simplifier les divers traitements et rapports, des outils doivent être mis en place pour réaliser les calculs nécessaires et indiquer les entités (joueurs, monstres, objets, butin) concernés, le tout selon le formalisme attendu.

Ces outils doivent être accessibles par l'administration de Dùralas mais aussi par les joueurs afin qu'ils puissent fournir une aide supplémentaire.


# HelperTools

Ce projet réalisé en Symfony 5 est un ensemble de formulaires réalisant des traitements selon des données de référence et des données fournies par l'utilisateur afin de présenter le template du rapport qui devra être posté par Le Marchand, Le Juge ou tout autre gestionnaire RP.

Afin de fournir une gestion informatique et utilisatrice efficace et efficiente, le projet repose sur l'utilisation de [redis](https://redis.io/) pour ses caractères de cache (session ou résilient).

## Outils attendus

Chaque rapport de gestionnaire RP est une source d'outil d'aide demandant une gestion informatique plus ou moins compliquée :

* Commerce (Le Marchand)
    - [ ] Transaction dans une [boutique d'armes](public/doc/RegularShop.md)
    - [ ] Transaction dans une boutique de joueur (optionnel)
    - [ ] Transaction mono-cible dans l'Hôtel de Vente
    - [ ] Transaction multi-cible (dont échanges) dans l'Hôtel de Vente
    - [ ] Affichage des stocks dans l'Hôtel de Vente
* Métiers (Le Marchand)
    - [ ] Rapport de récolte (bûcheron, chasseur, mineur)
    - [ ] Rapport de fabrication (forgeron, forgeron d'armures, sculpteur)
* Combats (Le Juge)
    - [ ] Fiche de combat
    - [ ] Fiche de combat auto-évolutive
    - [ ] Attaques des non-joueurs
    - [ ] Rapport de fin de combat

-----

Il serait aussi possible de mettre à disposition des joueurs des outils pour la rédaction des RP (selon les lignes minimum ou les quêtes) et pour la gestion des demandes commerciales (achat/vente dans une boutique, achat/vente en Hôtel de Vente, transaction avec les autres joueurs).

Ces outils sont très optionnels et sont susceptibles d'évoluer

* Commerce
    - [ ] Demande de transaction dans une boutique
    - [ ] Transaction à l'Hôtel de Vente
* Rédaction
    - [ ] Rédiger des RP métier
    - [ ] Rédiger des RP

## Fonctionnalités attendues

Sont décrits les comportements attendus pour une gestion efficiente des outils, notamment par l'utilisation de redis :

* Équipement et butin en base de données
    - Nom, loot, prix
* Données joueur en cache serveur
    - Pièces d'or, expérience, points métier, sac
* Dernières générations en cache session
* Rapport des transactions effectuées
    - Grouper par transaction ou par joueur
