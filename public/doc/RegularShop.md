# Boutique "normale"

Dans chaque ville se trouve une "Boutique d'armes" où les joueurs peuvent acheter les équipements non issus de l'artisanat et surtout vendre à moitié prix leurs équipements.

Certaines boutiques possèdent leurs spécificités (armes régionales, lassos à Kastalinn, porte-bonheur et artéfacts à Guillaëd, récompenses d'Ynatlatt à Sitlantà, etc.) mais globalement le système reste similaire.

L'outil `regular_shop` gère le rapport des transactions dans les boutiques d'armes ou plutôt dans les boutiques RP.

## Fonctionnement

En cas d'achat, l'utilisateur liste les objets qu'il souhaite acquérir (soit par une liste prédéfinie soit en saisie libre) et renseigne le montant d'achat tout en précisant le nombre désiré.

En cas de vente, l'utilisateur liste les objets dont il souhaite se débarrasser et renseigne le prix d'origine, défini dans la liste du règlement dùralassien.

Le template généré indique les débits et crédits ainsi que le total.

Il est possible de renseigner la possession en pièces d'or du personnage afin d'indiquer le nouveau solde.

### Particularités

- La revente à Wystéria est de 75% du prix d'origine (contre 50% ailleurs).
- La revente de montures et de familiers à Ishtar est de 200 pièces d'or.
- La revente des équipements à Ishtar n'est pas possible.
- ...
