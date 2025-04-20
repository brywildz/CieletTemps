<?php
/**
 * @file sitemap.php
 * Page indiquant le plan du site
 */

/**
 * Titre de la page actuelle, utilisé dans la balise <title>
 * @var $title
 */
$title = "Plan du site";
/**
 * La métadonnée de description
 * @var $metaDesc
 */
$metaDesc ="Plan du site Ciel &amp; Temps : navigation simplifiée entre toutes les sections, services et fonctionnalités.";
/**
 * La Métadonnée pour les mots clés
 * @var $metaKeywords
 */
$metaKeywords ="plan du site, sitemap, navigation, structure, pages, sections, Ciel &amp; Temps";
/**
 * Feuille de style de la page
 * @var $css
 */
$css="sitemap.css";
include "includes/pageParts/header.inc.php";
?>

<section class="sitemapSection">
    <h1>🗺️ Plan du site</h1>

    <div class="sitemap">

        <div class="sitemap-column">
            <div class="line-content">
                <h3>Accueil</h3>
                <a href="index.php">Présentation du site</a>
                <a href="index.php#locateWeather">Prévisions météo locales (géolocalisation)</a>
                <a href="index.php#info">Info météorologique</a>
            </div>


            <div class="line-content">
                <h3>Statistiques</h3>
                <a href="stats.php#city">Classement des villes les plus consultées</a>
                <a href="stats.php">Graphique dynamique (JSON)</a>
            </div>
        </div>

        <div class="sitemap-column">
            <div class="line-content">
                <h3>Prévisions météo</h3>
                <a href="meteo.php#map">Recherche par région → département → ville</a>
                <a href="search.php">Recherche par nom</a>
            </div>

            <div class="line-content">
                <h3>Page développeur</h3>
                <a href="tech.php#image">API NASA : image du jour</a>
                <a href="tech.php#ip">API de géolocalisation : GeoPlugin, IPInfo, WhatIsMyIP</a>
            </div>
        </div>
    </div>

        <div style="margin-left: 870px; margin-top: 50px; margin-bottom: 50px;">
            <h3 style="text-align: left; margin-bottom: 0.8rem;">Ressources générales</h3>
            <a href="about.php">À propos du groupe projet</a>
            <a href="mentions.php">Mentions légales</a>
            <a href="contact.php">Contact</a>
            <a href="index.php#faq">FAQ</a>
        </div>
</section>

<?php
include "includes/pageParts/footer.inc.php";
?>
