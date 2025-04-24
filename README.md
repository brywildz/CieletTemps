# Ciel&Temps Site meteo 

 Ciel&Temps est un site web dynamique de previsions meteo et d'informations climatiques, developpe dans le cadre du module developpement Web en L2 Informatique a CY Cergy Paris Universite (2024-2025).

Le site permet a l utilisateur de consulter la meteo locale, d explorer une carte interactive, d acceder a des statistiques, des images pedagogiques et de personnaliser son experience (mode jour/nuit, cookies).


## Membres du groupe 27

- Dylan Manseri
- Amadou Bawol
  
## Technologies utilisees

-   Frontend : HTML5, CSS3 
-   Backend : PHP 8
-   Données: fichiers CSV, cookies
-   APIs externes :
    - OpenWeather (previsions meteo)
    - IPInfo, GeoPlugin, WhatIsMyIP (geolocalisation IP)
    - NASA APOD (image astronomique du jour)



## Fonctionnalites principales

- Consultation meteo par :
    - Recherche manuelle (ville)
    - Carte DOM-TOM / regions francaises (balises `<map>`)
    - Geolocalisation automatique via adresse IP

- Image aleatoire avec anecdote meteo/scientifique

- Statistiques dynamiques des villes les plus consultees
    - Graphiques generes en PHP
    - Stockage dans (ranking.csv)

- Mode sombre / jour personnalisable (cookie)

- Utilisation de fichiers CSV : (regions.csv, departements.csv, communes.csv, ranking.csv)

- Cookies geres avec interface :
    - Affichage des cookies actifs
    - Réinitialisation possible

- FAQ sur la meteo est le site en generale



## Pages du site

| Page            | Description                                                      
|-----------------|------------------------------------------------------------------
| `index.php`     | Accueil, meteo par IP, image aleatoire, FAQ                     
| `meteo.php`     | Recherche par carte DOM-TOM / regions                           
| `search.php`    | Recherche libre de ville                                        
| `stats.php`     | Statistiques des villes les plus consultees                     
| `tech.php`      | Affichage d APIs techniques (NASA, geolocalisation IP)          
| `faq.php`       | Questions frequentes                                            
| `apropos.php`   | Presentation des membres du projet                              
| `mentions.php`  | Mentions legales                                                
| `contact.php`   | Coordonnees et reseaux sociaux                                  
| `cookies.php`   | Visualisation / suppression des cookies                         
| `sitemap.php`   | Plan du site                                                                                             



## Lien utile

Site web : (https://manseri.alwaysdata.net) (https://bawol.alwaysdata.net/index.php)
Code source : (https://github.com/brywildz/ProjetMeteo)



## Atouts pedagogiques

- Appels API JSON / XML en PHP
- Manipulation de fichiers CSV sans base de données
- Gestion des cookies et de la personnalisation
- Structuration modulaire du code PHP
- Affichage de données et responsive design



## Vie privee

Aucun cookie tiers.  
Les seuls cookies utilises sont :
- `style' : theme clair/sombre
- `derniere_ville` : derniere ville consultee

L utilisateur peut reinitialiser les cookies via `cookies.php`.
