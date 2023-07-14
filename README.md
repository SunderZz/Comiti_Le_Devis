# Comiti_Le_Devis

Petite précision sur mes choix :

- Aux niveau des inputs, je les ais "sécurisés" avec FILTER_SANITIZE_SPECIAL_CHARS afin, j'ai rajouter un pattern pour qu'on ne puisses ajouter des signes, et j'ai aussi mis en place une fonction js afin de limité la length des inputs

- J'ai décidé d'afficher les nombres 2 chiffres apres la decimales

- Il était aussi possible de créer des classes pour listé des propriétés et aussi pour différencié les méthodes

- Je n'ai pas gérer la durée des jetons pour une question de pratique de démo alors les jetons seront générer à chaque sessions

- J'avais le choix de faire une BDD, j'ai préférer créer un service de jetons car le language utilisé devait être du PHP
