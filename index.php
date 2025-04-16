<?php
$title = "Accueil";
$css = "index.css";
include "includes/pageParts/header.inc.php";
include "includes/functions/functionRanking.php";
include "includes/functions/functions.inc.php";
include "includes/functions/functionsTech.php";
?>


    <section class="accueil">
        <h1 class="newgen">Ciel&Temps</h1>
        <p class="slogan"><em>Les infos du ciel à tout temps !</em></p>
        <div class="locate-info">
            <?php
            $geoJson = getPositionJSON();
            //list($latitude, $longitude) = explode(",", $geoJson["loc"]);
            $insee = getInseeCode($geoJson["city"]);
            $weather = getWeather($insee);
            ?>
            <h2><?= $geoJson["city"] ?> : <?= $weather["weather"][0]["description"] ?></h2>
            <div style="display: flex">
                <img src="https://openweathermap.org/img/wn/<?= $weather["weather"][0]["icon"] ?>@2x.png" alt="Illustration météo"/>
                <p style="font-size: 35px"><?= $weather["main"]["temp"] ?>°C</p>
            </div>
            <a class="see-more" href="meteo.php?city=<?= $geoJson["city"] ?>#selection">Voir plus</a>
        </div>
    </section>
<section class="default-section" style="text-align: center; padding: 2rem;">
    <p>
        Bienvenue sur <strong>Ciel&Temps</strong>, votre plateforme météo intelligente et interactive.
        Ce site vous permet de consulter en temps réel les <strong>prévisions météo</strong> selon votre <em>région</em>, <em>département</em> ou <em>ville</em>.
        Grâce à notre système de <strong>géolocalisation</strong>, vous pouvez connaître immédiatement la météo là où vous vous trouvez.
    </p>
    <img src= "<?php echo 'imageAleatoire/'.chiffreAleatoire()?>.jpg" alt="image aléatoire" style="text-align: center; border-radius: 10%"/>
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
<section class="classic">
    <h2>Classement des villes les plus consultées</h2>
    <?php $ranking = getRankingCitiesCsv() ?>
    <?php if(!empty($ranking)): ?>
        <?php printRanking($ranking); ?>
    <?php else: ?>
        <?php echo "Aucune n'a encore été consultée" ?>
    <?php endif; ?>
</section>

<section class="classic" style="text-align: center; padding: 2rem;">
    <h2>Navigation rapide</h2>
    <ul style="list-style: none; padding: 0;">
        <li><a href="tech.php">👨‍💻 Page développeur</a></li>
        <li><a href="meteo.php">🗺️ Carte interactive</a></li>
        <li><a href="meteo.php">📍 Météo géolocalisée (à venir)</a></li>
        <li><a href="#">📊 Statistiques climatiques (à venir)</a></li>
    </ul>
</section>

<?php
include "includes/pageParts/footer.inc.php";
?>
