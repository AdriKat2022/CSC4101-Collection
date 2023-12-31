# CSC4101_Collection
This is a small project with Symfony by creating a web collection with PHP supposed interactable with users.

The main goal is to train my skills with PHP by generating a solid database and learn how to interact with it the best.

# Project description

**If you want to skip to how start the project, go straight to the *Help to start the project***

For proper display of the .MD markdown format, go to my [GitHub page](https://github.com/AdriKat2022/CSC4101-Collection).


## Main specifications

As a web application, this project should include a login system so users can have their own book of cards. A HearthstoneCardbook should be owned by a member, and contains as many cards as the member wants.
Member are able to share a selection of their cards (all Hearthstone Cardbooks included) to create decks. These may be published for the public (or not) by the owner member, so everyone including unregistered users, can view them.

## Current Advancement

**You should be able to navigate and see ALL possible pages from the interface itself, without having to touch the URL.**

Front office is fully active.
- Login system is up and any existing member can log in, browse decks and access their account. From there, members can create hearthstone cardbooks, decks and cards for their account.
- Anonymous users can still look at public decks from other users and look at theirs associated cards. They can't create decks or any other type of entity.

Back office is also fully active, not counting minor bugs (see section below). Only admin users can access it.
- All entities are indexed and can be viewed.
- There is a link that takes you back to the front-office to facilitate the website's use (no need to retype an url).

### Known minor bugs

- A new user can't register on this website as I did not tackle the register part of this project. New member accounts may be created with easy admin, but users (the logins associated with members, see the **Code names and entities** section below for further details) should be added within the fixtures of the project, which is absolutely not *production-environment friendly*.
- When creating a card, the form will ask you for an attack and hp value even if the **isminion** property is turn off. In this case, whether you provide a value or not doesn't matter, as null values would replace them.
- When editing certain entities with EasyAdmin, a weird symfony error might appear, altering the CSS of the page. Fortunately, this error doesn't seem to interfere with the edition of the database however (you can proceed as it weren't here).

## Collections used in the project

The collection that I will display in this project, will be **HEARTHSTONE CARDS**.

### Description

A hearthstone card is made from several components :
- A name (string)
- A description (string)
- A mana cost (integer)
- A type (spell or minion)   (bool)
- An attack value (only if minion, interger)
- A HP value (only if minion, interger)
- A photo (not customisable) (file_link -> string)


### Code names and entities

|Abstract|Use in project|
|---|---|
|Object| Hearthstone Card|
|Inventory| Hearthstone Cardbook|
|Gallery | Deck|
|Member | Member|
|User | User|

So the differents entities are in order :
- User
- Member
- Hearthstone Cardbook (containing all cards of a member)
- Hearthstone Deck (at the wish of the member, collection of selected cards to share them to the world)
- Hearthstone Card (must be owned by a Hearthstone Cardbook)




## Help to start the project

- `symfony server:start` to start the server in the root file of this project, then connect to [localhost:8000/](localhost:8000/) in your navigator.
- `symfony console debug:router` to see the available urls that work (not recommended for the experience)

### User list to try

|Member|Username|Password|
|---|---|
| Adrien| adrikat | mouhahaphp |
| Alice |alice | alice |
| The Lich King |the_lich | fruit |
| Anduin | anduin | anduin |
| Malfurion | malfurion | malfurion |
| Shy guy | [noUser] | [noUser] |


# TODO

## Detailed todolist

| Done | Task number | Description | Importance | Learning TP |
|---|---|---|---|---|
|[x] |1  |  prise de connaissance du cahier des charges|  OBLIGATOIRE|  TP 3|
|[x] |2 	|initialisation du projet Symfony| 	OBLIGATOIRE|	TP 3|
|[x] |3 	|gestion du code source avec Git 	|RECOMMANDÉ |	  	 |
|[x] |4 	|ajout au modèle des données des entités liées [inventaire] et [objet] minimales<br>4.1 	- entité [inventaire] 	'' 	''<br>4.2 	- entité [objet] 	'' 	''<br>4.3 	- association 1-N entre [inventaire] et [objet] 	'' 	''<br>4.4 	- propriétés non-essentielles des [objets] (optionnel) 	|OPTIONNEL 	| | 
|[x] |5 	|ajout de données de tests chargeables avec les fixtures<br>- pour [inventaire]<br>- pour [objet]<br>- … |OBLIGATOIRE 	|TP 3 	 |
|[x] |6 	|ajout d'une interface EasyAdmin dans le back-office avec les 2 contrôleurs CRUD [inventaire] et [objet]<br>- CRUD [inventaire] TP 3/4<br>- CRUD [objet] 	TP 3/4<br>- navigation entre [inventaire] et ses [objets] 	|OPTIONNEL| 	TP 5 	 |
|[x] |7 	|ajout de l'entité membre et du lien membre - [inventaire]<br>- ajout de membre au modèle des données<br>- ajout de l'association 1-N entre membre et ses inventaires (optionnellement 1-1) 	  	 |OBLIGATOIRE 	|TP 3/4 	| 
|[x] |8 	|création des pages du "front-office" de consultation des [inventaires]<br>- consultation de la liste de tous les inventaires (dans un premier temps)<br>- consultation d'une fiche d'[inventaire] à partir de la liste 	|OBLIGATOIRE 	|TP 4 	 |
|[x] |9 	|ajout de la navigation entre [inventaire] et [objet] dans le back-office EasyAdmin 	|OPTIONNEL 	|TP 4/5 	 |
|[x] |10 	|utilisation de gabarits pour les pages de consultation du front-office<br>- consultation d'un [objet]<br>- consultation de la liste des [objets] d'un [inventaire]<br>- navigation d'un [inventaire] vers la consultation de ses [objets] |OBLIGATOIRE 	|TP 5 |
|[x] |11 	|intégration d'une mise en forme CSS avec Bootstrap dans les gabarits Twig| 	OBLIGATOIRE| 	TP 6|
|[x] |12 	|intégration de menus de navigation 	|OBLIGATOIRE 	  	| |
|[x] |13 	|ajout de l'entité [galerie] au modèle des données et de l'association M-N avec [objet] 	|OBLIGATOIRE| |
|[x] |14 	|ajout de [galerie] dans le back-office 	|OPTIONNEL 	 | 	 |
|[x] |15 	|ajout d'un contrôleur CRUD au front-office pour [galerie] 	|OBLIGATOIRE | TP 7|
|[x] |16 	|ajout de fonctions CRUD au front-office pour [inventaire] 	|OBLIGATOIRE 	|   	 |
|[x] |17 	|ajout de la consultation des [objets] depuis les [galeries] publiques| 	OBLIGATOIRE| |
|[x] |18 	|ajout d'un contrôleur CRUD pour Membres 	|OBLIGATOIRE 	|  	 |
|[x] |19 	|consultation de la liste des seuls inventaires d'un membre dans le front-office| 	OBLIGATOIRE| 	|
|[x] |20 	|contextualisation de la création d'[inventaire] en fonction du Membre 	|OBLIGATOIRE 	  	 
|[x] |21 	|contextualisation de la création d'un [objet] en fonction de l'[inventaire] 	|OBLIGATOIRE |  	 |
|[x] |22 	|contextualisation de la création d'une [galerie] en fonction du membre 	|OPTIONNEL 	|  	 |
|[x] |23 	|affichage des seules galeries publiques 	|OPTIONNEL| 	  	 |
|[x] |24 	|contextualisation de l'ajout d'un [objet] à une [galerie] 	|OPTIONNEL| 	  	 |
|[x] |25 	|ajout des Utiisateurs au modèle de données et du lien utilisateur - membre 	|OBLIGATOIRE 	|TP 9 	 
|[x] |26 	|ajout de l'authentification 	|OBLIGATOIRE 	|TP 9 	 
|[x] |27 	|protection de l'accès aux routes interdites réservées aux membres 	|OPTIONNEL 	|TP 9 	 |
|[x] |28 	|protection de l'accès aux données à leurs seuls propriétaires 	|OPTIONNEL 	|TP 9 	 
|[x] |29 	|contextualisation du chargement des données en fonction de l'utilisateur connecté 	|OPTIONNEL |	  	 |
|[x] |30 	|Gestion de la suppression 	|OPTIONNEL 	|  	 |
|[ ] |31 	|ajout de la gestion de la mise en ligne d'images pour des photos dans les [objet] 	|OPTIONNEL 	| TP 8|
|[ ] |32 	|utilisation des messages flash pour les CRUDs| 	OPTIONNEL|  |
|[ ] |33 	|ajout d'une gestion de marque-pages/panier dans le front-office 	|OPTIONNEL 	|TP 9|



# Links and useful resources

- [Markdown cheat sheet](https://www.markdownguide.org/cheat-sheet/)
- [Project specification](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/cahier-charges-projet.html)
- [Project recommended checklist](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/checklist-projet.html)

