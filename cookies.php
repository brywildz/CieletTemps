<?php
$title = "Cookies";
$metaDesc ="Gérez vos préférences de cookies sur le site Ciel &amp; Temps : analyse, navigation, tiers. Respect de votre vie privée.";
$metaKeywords ="cookies, consentement, gestion des données, confidentialité, RGPD, préférences";
$css = "cookies.css";
include "includes/pageParts/header.inc.php";
include "includes/functions/functionsGlobal.php";

$deleted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_cookie'])) {
    deleteCookies(); // depuis functionsGlobal.php
    $deleted = true;
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

        <?php if ($deleted): ?>
            <p style="color: green;">✅ Cookies supprimés avec succès.</p>
        <?php endif; ?>

        <form style="margin-top: 15px" method="post">
            <button type="submit" name="reset_cookie" class="dark-mode">Réinitialiser les cookies</button>
        </form>
    </div>
</section>

<?php include "includes/pageParts/footer.inc.php"; ?>
