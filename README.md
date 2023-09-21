# CSC4101_Collection
This is a small project with Symfony by creating a web collection with PHP supposed interactable with users.

The main goal is to train my skills with PHP by generating a solid database and learn how to interact with it the best.

# Project description

## Main specifications

As a web application, this project should include a login system so users can have their own book of cards. A should be owned by a user, but several users can own a same card. We just suppose it exists in as much copies it needs to satisfy everyone.
Then, they will be able to share a part of their book to create albums for the public, so everyone, included inregistered users, can view them.

## Collections used in the project

The collection that I will display in this project, will be **HEARTHSTONE CARDS**.

### Description

A hearthstone card is made from several components :
- A name (string)
- A description (string)
- A mana cost (integer)
- A type (spell or minion)   (bool)
- An attack value (if minion, interger)
- A HP value (if minion, interger)
- A photo (optionnal) (file_link -> string)

### Others and miscellaneous

None for now.


# TODO

## Main todo

- [x] CHOOSE Collection
- [x] DESIGN the Database
- [ ] CREATE the project base
- [x] GENERATE the detailed todolist

## Detailed todolist

| Done | Task number | Description | Importance | Learning TP |
|---|---|---|---|---|
|[x] |1  |  prise de connaissance du cahier des charges|  OBLIGATOIRE|  TP 3|
|[ ] |2 	|initialisation du projet Symfony| 	OBLIGATOIRE|	TP 3|
|[x] |3 	|gestion du code source avec Git 	|RECOMMANDÉ |	  	 |
|[ ] |4 	|ajout au modèle des données des entités liées [inventaire] et [objet] minimales<br>4.1 	- entité [inventaire] 	'' 	''<br>4.2 	- entité [objet] 	'' 	''<br>4.3 	- association 1-N entre [inventaire] et [objet] 	'' 	''<br>4.4 	- propriétés non-essentielles des [objets] (optionnel) 	|OPTIONNEL 	| | 
|[ ] |5 	|ajout de données de tests chargeables avec les fixtures<br>- pour [inventaire]<br>- pour [objet]<br>- … |OBLIGATOIRE 	|TP 3 	 |
|[ ] |6 	|ajout d'une interface EasyAdmin dans le back-office avec les 2 contrôleurs CRUD [inventaire] et [objet]<br>- CRUD [inventaire] TP 3/4<br>- CRUD [objet] 	TP 3/4<br>- navigation entre [inventaire] et ses [objets] 	|OPTIONNEL| 	TP 5 	 |
|[ ] |7 	|ajout de l'entité membre et du lien membre - [inventaire]<br>- ajout de membre au modèle des données<br>- ajout de l'association 1-N entre membre et ses inventaires (optionnellement 1-1) 	  	 |OBLIGATOIRE 	|TP 3/4 	| 
|[ ] |8 	|création des pages du "front-office" de consultation des [inventaires]<br>- consultation de la liste de tous les inventaires (dans un premier temps)<br>- consultation d'une fiche d'[inventaire] à partir de la liste 	|OBLIGATOIRE 	|TP 4 	 |
|[ ] |9 	|ajout de la navigation entre [inventaire] et [objet] dans le back-office EasyAdmin 	|OPTIONNEL 	|TP 4/5 	 |
|[ ] |10 	|utilisation de gabarits pour les pages de consultation du front-office<br>- consultation d'un [objet]<br>- consultation de la liste des [objets] d'un [inventaire]<br>- navigation d'un [inventaire] vers la consultation de ses [objets] |OBLIGATOIRE 	|TP 5 |
|[ ] |11 	|intégration d'une mise en forme CSS avec Bootstrap dans les gabarits Twig| 	OBLIGATOIRE| 	TP 6|
|[ ] |12 	|intégration de menus de navigation 	|OBLIGATOIRE 	  	| |
|[ ] |13 	|ajout de l'entité [galerie] au modèle des données et de l'association M-N avec [objet] 	|OBLIGATOIRE| |
|[ ] |14 	|ajout de [galerie] dans le back-office 	|OPTIONNEL 	 | 	 |
|[ ] |15 	|ajout d'un contrôleur CRUD au front-office pour [galerie] 	|OBLIGATOIRE | TP xxx|
|[ ] |16 	|ajout de fonctions CRUD au front-office pour [inventaire] 	|OBLIGATOIRE 	|   	 |
|[ ] |17 	|ajout de la consultation des [objets] depuis les [galeries] publiques| 	OBLIGATOIRE| |
|[ ] |18 	|ajout d'un contrôleur CRUD pour Membres 	|OBLIGATOIRE 	|  	 |
|[ ] |19 	|consultation de la liste des seuls inventaires d'un membre dans le front-office| 	OBLIGATOIRE| 	|
|[ ] |20 	|contextualisation de la création d'[inventaire] en fonction du Membre 	|OBLIGATOIRE 	  	 
|[ ] |21 	|contextualisation de la création d'un [objet] en fonction de l'[inventaire] 	|OBLIGATOIRE |  	 |
|[ ] |22 	|contextualisation de la création d'une [galerie] en fonction du membre 	|OPTIONNEL 	|  	 |
|[ ] |23 	|affichage des seules galeries publiques 	|OPTIONNEL| 	  	 |
|[ ] |24 	|contextualisation de l'ajout d'un [objet] à une [galerie] 	|OPTIONNEL| 	  	 |
|[ ] |25 	|ajout des Utiisateurs au modèle de données et du lien utilisateur - membre 	|OBLIGATOIRE 	|TP 9 	 
|[ ] |26 	|ajout de l'authentification 	|OBLIGATOIRE 	|TP 9 	 
|[ ] |27 	|protection de l'accès aux routes interdites réservées aux membres 	|OPTIONNEL 	|TP 9 	 |
|[ ] |28 	|protection de l'accès aux données à leurs seuls propriétaires 	|OPTIONNEL 	|TP 9 	 
|[ ] |29 	|contextualisation du chargement des données en fonction de l'utilisateur connecté 	|OPTIONNEL |	  	 |
|[ ] |30 	|Gestion de la suppression 	|OPTIONNEL 	|  	 |
|[ ] |31 	|ajout de la gestion de la mise en ligne d'images pour des photos dans les [objet] 	|OPTIONNEL 	| TP 8|
|[ ] |32 	|utilisation des messages flash pour les CRUDs| 	OPTIONNEL|  |
|[ ] |33 	|ajout d'une gestion de marque-pages/panier dans le front-office 	|OPTIONNEL 	|TP 9|


# Links and useful resources

- [Markdown cheat sheet](https://www.markdownguide.org/cheat-sheet/)
- [Project specification](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/cahier-charges-projet.html)
- [Project recommended checklist](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/checklist-projet.html)
