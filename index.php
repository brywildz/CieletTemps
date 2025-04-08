<?php
$title = "Accueil";
include "includes/header.inc.php";
include "includes/functions.inc.php"
?>

<section style="text-align: center; padding: 2rem;">
    <h1>Ciel&Temps 🌍</h1>
    <p>
        Bienvenue sur <strong>Ciel&Temps</strong>, votre plateforme météo intelligente et interactive.
        Ce site vous permet de consulter en temps réel les <strong>prévisions météo</strong> selon votre <em>région</em>, <em>département</em> ou <em>ville</em>.
        Grâce à notre système de <strong>géolocalisation</strong>, vous pouvez connaître immédiatement la météo là où vous vous trouvez.
    </p>
    <p>
        En plus des prévisions classiques, vous y trouverez une <strong>carte interactive</strong>, des <strong>données issues d’API météo</strong>,
        ainsi que des fonctionnalités en cours de développement, comme l’analyse de tendances climatiques.
    </p>

    <p style="margin-top: 1rem;">
        <a href="?style=sombre" style="background-color: #444; color: #fff; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
            🌙 Mode sombre
        </a>
        <a href="?style=clair" style="background-color: #ddd; color: #000; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; margin-left: 1rem;">
            ☀️ Mode clair
        </a>
    </p>

</section>
<section>
    <h2>Classement des villes les plus consultées</h2>
    <?php $ranking = getRankingCitiesJson() ?>
    <?php if(!empty($ranking)): ?>
        <?php printRanking($ranking); ?>
    <?php endif; ?>
</section>

<section style="text-align: center; padding: 2rem;">
    <h2>Navigation rapide</h2>
    <ul style="list-style: none; padding: 0;">
        <li><a href="tech.php">👨‍💻 Page développeur</a></li>
        <li><a href="meteo.php">🗺️ Carte interactive</a></li>
        <li><a href="meteo.php">📍 Météo géolocalisée (à venir)</a></li>
        <li><a href="#">📊 Statistiques climatiques (à venir)</a></li>
    </ul>
</section>

<?php
include "includes/footer.inc.php";
?>
