# Comiti_Le_Devis

Petite précision sur mes choix :

- Aux niveau des inputs, je les ais "sécurisés" avec FILTER_SANITIZE_SPECIAL_CHARS afin, qu'on ne puisses ajouter de signes, et j'ai aussi mis en place une fonction js afin de limité la length des inputs

- J'ai décidé d'afficher le nombre de chiffres de 2 apres la decimales 

- Il était aussi possible de créer des classes pour listé des propriétés et aussi pour différencié les méthodes

- Je n'ai pas gérer la durée des jetons pour une question de pratique de démo alors les jetons seront générer à chaque sessions

- J'avais le choix de faire une BDD, j'ai préférer créer un service de jetons car le language utilisé devait être du PHP

- Il manquerait la gestion de vol de session poussée mais comme je ne suis pas parfaitement au point sur le sujet, je ne préfère pas le mettre
