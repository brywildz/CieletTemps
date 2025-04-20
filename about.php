<?php
/**
 * @file about.php
 * Page concernant les informations des auteurs du site
 */

/**
 * Titre de la page actuelle, utilisé dans la balise <title>
 * @var $title
 */
$title = "À propos";
/**
 * La métadonnée de description
 * @var $metaDesc
 */
$metaDesc ="Découvrez les objectifs, la démarche et l’équipe derrière Ciel &amp; Temps, projet universitaire en informatique.";
/**
 * La Métadonnée pour les mots clés
 * @var $metaKeywords
 */
$metaKeywords ="à propos, projet, étudiants, L2 informatique, CY Cergy, équipe, présentation";
/**
 * Feuille de style de la page
 * @var $css
 */
$css = "about.css";
include "includes/pageParts/header.inc.php";
?>

<h1>À propos du projet</h1>
<section class="default-section" style=
"<?php if($styleName == "light") :?>background-color:white; <?php else:?> background-color:#1F1F1F; <?php endif;?> border-radius:5px;">
    <h2>Contexte</h2>
    <p>
        Ce site a été développé dans le cadre du module <strong>Développement Web</strong> en <strong>Licence 2 Informatique</strong> à
        <strong>CY Cergy Paris Université</strong> (2024-2025).
    </p>

    <p>
        <strong>Ciel&amp;Temps</strong> est né de notre envie de créer un site utile et accessible à tous. L'idée : proposer une interface claire
        pour consulter la météo, découvrir des images inspirantes, et en apprendre un peu plus sur le climat, le tout de façon interactive
        et agréable. C’est un projet pédagogique, mais qu’on a voulu soigner, fonctionnel, et un peu ambitieux aussi.
    </p>

    <h2 style="text-align: center; margin-top: 3rem;">👨‍💻 Les membres du projet</h2>

    <div class="author-div">
        <div>
            <img src="images/about/dylan.webp" alt="Photo de Dylan"/>
            <h3>Dylan Manseri</h3>
            <p>
                Passionné d’informatique depuis toujours, curieux de tout ce qui touche au web, aux interfaces et à l'expérience utilisateur.
                Il aime concevoir des outils utiles, clairs et élégants, avec une attention portée aux détails.
                Il rêve de créer un jour ses propres solutions logicielles innovantes.
            </p>
        </div>

        <div>
            <img src="images/about/amadou.webp" alt="Photo d'Amadou"/>
            <h3>Amadou Bawol</h3>
            <p>
                Avides de savoir et passionné par les défis techniques,
                Amadou s'intéresse particulièrement à la cybersécurité et à la data science.
                Il voit dans l’informatique un domaine en constante évolution, où il peut apprendre,
                innover et contribuer à un monde plus connecté et sécurisé.
            </p>

        </div>
    </div>
</section>

<?php
include "includes/pageParts/footer.inc.php";
?>
