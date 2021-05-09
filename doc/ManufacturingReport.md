# Rapport de fabrication

Les métiers de manufacture (sculpteur, forgeron [armes] et forgeron d'armures) s'effectuent, par défaut, dans les zones RP de manufacture. Mais ils peuvent aussi s'effectuer ailleurs et notamment dans les boutiques personnelles des manufacturiers.

Chaque manufacturier a accès à un catalogue de recettes artisanales conditionnées par son niveau du métier exercé, dépendant de ses points métier (PM) : novice [0], apprenti [41], compagnon [81], expert [121], maître [161], maître absolu [200].

Tant qu'un manufacturier possède les ressources nécessaires, il peut fabriquer à tout moment une ou plusieurs recettes (en respectant le nombre de lignes pour chaque fabrication).

L'outil `manufacturing_report` gère le rapport de fabrication du manufacturier.

## Fonctionnement

Selon le nombre de points métier du personnage, le manufacturier aura accès à divers recettes lui demandant des ressources qu'il devra se procurer. Une fois la fabrication effectuée, le manufacturier récupère son produit et gagne des points métier prouvant son expertise grandissante.

Si le RP est de qualité, le personnage peut obtenir des points métier en bonus. 

Des quêtes métier sont à disposition et le personnage récupérera des récompenses prédéfinies : pièces d'or, expérience, ressources, butins, etc.

L'administration précisera un commentaire sur la fabrication.

### Particularités

- Un maître absolu a accès à l'amélioration de n'importe quelle pièce d'équipement régie par son métier (dont celle qu'il est en train de fabriquer).
- L'artisanat djöllfulin est régi selon des règles particulières.
- ...
