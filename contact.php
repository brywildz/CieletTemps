<?php
/**
 * @file contact.php
 * Page de répertoriant les différents contact du site
 */

/**
 * Titre de la page actuelle, utilisé dans la balise <title>
 * @var $title
 */
$title = "Contact";
/**
 * La métadonnée de description
 * @var $metaDesc
 */
$metaDesc ="Contactez les développeurs du site Ciel &amp; Temps pour toute question, suggestion ou collaboration.";
/**
 * La Métadonnée pour les mots clés
 * @var $metaKeywords
 */
$metaKeywords ="contact, formulaire, support, email, développeurs, météo, projet étudiant";
/**
 * Feuille de style de la page
 * @var $css
 */
$css="contact.css";
include "includes/pageParts/header.inc.php";
?>

<section class="classic">
    <h1>📬 Contact</h1>

    <h2>👨‍💻 Qui sommes-nous ?</h2>
    <p>
        Nous sommes Dylan Manseri et Amadou Bawol, deux étudiants ayant pour objectif de rendre l’accès à la météo simple, rapide et accessible à tous, à tout moment.
    </p>

    <h2>📧 Nous contacter</h2>
    <ul>
        <li>Adresse email principale : <strong>contactCiel&amp;temps@gmail.com</strong></li>
        <li>Téléphone (fictif) : <strong>+33 6 12 34 56 78</strong></li>
        <li>Adresse (fictif) : <strong>33 avenue du Soleil levant, 95000 Cergy, France</strong></li>
    </ul>

    <h2>📱 Suivez-nous sur les réseaux sociaux pour suivre en direct nos actualités </h2>
    <ul>
        <li>🐦 <strong>Twitter / X :</strong> <a style="text-align: left" href="https://x.com/EtTemps81032" target="_blank">@CielEtTemps</a></li>
        <li>📸 <strong>Instagram :</strong> <a style="text-align: left" href="https://www.instagram.com/cielettemps_officiel" target="_blank">@ciel.et.temps</a></li>
        <li>▶️ <strong>YouTube :</strong> <a style="text-align: left" href="https://www.youtube.com/@CielEtTemps-Officiel" target="_blank">Ciel&amp;Temps-Officiel</a></li>
    </ul>

    <p>Nous sommes ouverts à toutes suggestions, collaborations ou simples messages d'encouragements 🙂</p>
</section>

<?php include "includes/pageParts/footer.inc.php"; ?>
