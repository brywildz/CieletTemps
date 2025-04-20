<?php
/**
 * @file cookies.php
 * Page concernant la manipulations des cookies
 */

/**
 * Titre de la page actuelle, utilisé dans la balise <title>
 * @var $title
 */
$title = "Cookies";
/**
 * La métadonnée de description
 * @var $metaDesc
 */
$metaDesc ="Gérez vos préférences de cookies sur le site Ciel &amp; Temps : analyse, navigation, tiers. Respect de votre vie privée.";
/**
 * La Métadonnée pour les mots clés
 * @var $metaKeywords
 */
$metaKeywords ="cookies, consentement, gestion des données, confidentialité, RGPD, préférences";
/**
 * Feuille de style de la page
 * @var $css
 */
$css = "cookies.css";
include "includes/pageParts/header.inc.php";
include "includes/functions/functionsGlobal.php";

$deleted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_cookie'])) {
    deleteCookies(); // depuis functionsGlobal.php
    /**
     * Booléen indiquant si les cookies ont bien été supprimé
     * @var $deleted
     */
    header("Location: cookies.php?deleted=1");
    exit;
}
?>

<section class="classic">
    <h1>🍪 Gestion des cookies</h1>

    <p>Cette page vous permet de visualiser les cookies actuellement utilisés sur ce site ainsi que de les réinitialiser si vous le souhaitez.</p>

    <div class="cookie-section">
        <h2>Cookies actifs :</h2>
        <ul style='list-style: none; margin-left: 15px'>
            <?php
            if (empty($_COOKIE)) {
                echo "<li>Aucun cookie détecté.</li>";
            } else {
                foreach ($_COOKIE as $name => $value) {
                    echo "<li><strong>$name</strong> : $value</li>";
                }
            }
            ?>
        </ul>

        <?php if (isset($_GET['deleted'])): ?>
            <p style="color: green;">✅ Cookies supprimés avec succès.</p>
        <?php endif; ?>

        <form style="margin-top: 15px" method="post">
            <button type="submit" name="reset_cookie" class="dark-mode">Réinitialiser les cookies</button>
        </form>
    </div>
</section>

<?php include "includes/pageParts/footer.inc.php"; ?>
