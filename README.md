# AnnuaireMusees_Back (ARCHIVED)
Application : Annuaire des musées (Back-end)

##Le contect :
Projet initié suite au souhait d'une entreprise de tester mes compétences php pour valider ou non une embauche.

##Le sujet :  
Développer un mini annuaire des musées permettant la gestion de catégories et de fiches :  
- Il devra être possible de gérer une arborescence de catégories sur plusieurs niveaux (ajout, modification et suppression). Chaque catégorie sera au minimum constituée d'un libellé.  
- Il devra être possible de créer/modifier/supprimer des fiches de l'annuaire. Chaque fiche constituée au minimum d'un libellé et d'une description sera associée à une ou plusieurs catégories.  

Le développement devra être développé en PHP (sans framework) et mysql. Je laisse libre court à votre imagination au niveau du style. Nous serons néanmoins sensible à la bonne architecture du code ainsi qu'au bon fonctionnement de l'outil.
  
##Délai :
1 semaine

##Conclusion tranmise à l'entreprise :
Dans le délai qui m'était donné, je n'ai pas pu respecté entièrement les points suivants :
 - Possibilité d'attribuer plusieurs catégories à un musée
 - Rendre visible l'arborescence des catégories

il reste un certain nombre de chose à faire :
 - Contrôle sur la saisie
 - Contrôler le bon affichage des tableaux (du fait de l'architecture choisi, il peut arriver que la partie Back-End ne réponde pas assez vite pour la partie front ce qui génère une erreur. Dans ce cas, il suffit d'actualiser la page)

Au niveau de l'architecture, le projet est découpé en deux sous-projets (Back et Front)

1-/Le Back-End (PHP/MySQL)
Le back-end met à disposition deux urls permettant de réaliser des actions sur les musées (http://back.annuaire.webizone.fr/musee/) et sur les catégories (http://back.annuaire.webizone.fr/categorie/) en utilisant les requête GET, POST, PUT et DELETE. 
Il s'occupe donc de faire les interactions avec la base de données.

2-/Le Front--End (AngularJS)
Le front-end consomme les services fournis par le back-end pour permettre de gérer les musées et les catégories, il est accessible à l'adresse suivante : http://annuaire.webizone.fr/ 
Afin de simplifier le plus possible l'expérience utilisateur, vous ne trouverez que deux écrans (un pour les musées et un pour les catégories) qui permettent l'ensemble des actions CRUD à travers un tableau modifiable par simple clique.
