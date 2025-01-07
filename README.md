# Projet Ryuk
## Une mort est si vite arrivée

<style>
r { color: #F94449 }
</style>

> **Equipe :**   
> Melvyn BAUVENT,  
> Julien CHATAIGNER,  
> Lilas GRENIER,  
> Simon PRIBYLSKI


## Navigation
Page d'accueil 
> contenant une cause de mort, tirée aléatoirement

Page principale
> avec statistiques générales, Darwin Awards

Page de statistique ciblées
> en fonction des réponses à un formulaire 

Page testament
> Contient un template de testament

Simulateur d'assurance vie
> En fonction des données les plus récentes ?

Page de ressources
> Suicide preventions hotlines, etc.


## Architecture du projet
Framework php : Symfony.



### Racine

- Dossier [config](config) contenant la configuration du projet
- Dossier [migrations](migrations)  contenant les dossiers concernant la base de données, dont les fichiers sont utilisés par l'[ORM Doctrine](https://www.doctrine-project.org/). <r>*Ne pas modifier !*<r>
- Dossier [public](public) contenant le fichier [index.php](public\index.php)
- Dossier [src](src) contenant le code en lui-même
- Dossier [vendor](vendor)



## Base de données
- [API des personnes décédées (data.gouv.fr)](https://www.data.gouv.fr/fr/reuses/api-des-personnes-decedees/)
- [Liste des personnes décédées en France collectées depuis 1970](https://public.opendatasoft.com/explore/dataset/liste-des-personnes-decedees-en-france/table/)
- [Fichier des prénoms depuis 1900 (data.gouv.fr)](https://www.data.gouv.fr/fr/datasets/fichier-des-prenoms-depuis-1900/)
- [Défibrillateurs Automatisés Externes - France - données OSM](https://public.opendatasoft.com/explore/dataset/osm-france-defibrillator/table/?disjunctive.meta_code_com&disjunctive.meta_code_dep&disjunctive.meta_code_reg)
- [Établissements de santé - France - données OSM](https://public.opendatasoft.com/explore/dataset/osm-france-healthcare/)
- [Monuments aux morts en France (OpenStreetMap)](https://www.data.gouv.fr/fr/datasets/monuments-aux-morts-presents-en-france-dans-les-donnees-openstreetmap/)
- [Prénoms donnés par département](https://public.opendatasoft.com/explore/dataset/demographyref-france-prenoms-departement-millesime/)
- [Causes de décès (data.gouv.fr)](https://www.data.gouv.fr/fr/datasets/causes-de-deces/)
- [Nombre de décès quotidiens par département](https://www.data.gouv.fr/fr/datasets/nombre-de-deces-quotidiens-par-departement/)
- [Causes de décès par sexe et âge de 1925 à 1999 (data.gouv.fr)](https://www.data.gouv.fr/fr/datasets/causes-de-deces-par-sexe-et-age-de-1925-a-1999/)