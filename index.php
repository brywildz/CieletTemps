<?php
$title = "Accueil";
$metaDesc = "Ciel &amp; Temps est un site météo interactif permettant de consulter les prévisions en France grâce à une carte interactive, 
une recherche par ville et des statistiques détaillées.";
$metaKeywords = "météo, carte interactive, prévisions météo, géolocalisation, statistiques météo, Ciel et Temps, Dylan Manseri, Amadou Bawol";
$css = "index.css";
include "includes/pageParts/header.inc.php";
include "includes/functions/functionRanking.php";
include "includes/functions/functionsGlobal.php";
include "includes/functions/functionsTech.php";
include "includes/functions/functionRandomImage.php";
?>
    <section class="accueil">
        <h1 class="newgen">Ciel&amp;Temps</h1>
        <p class="slogan"><em>Votre météo, tout simplement.</em></p>
        <div class="locate-info" id="locateWeather">
            <?php
            $geoJson = getPositionJSON();
            //list($latitude, $longitude) = explode(",", $geoJson["loc"]);
            $coo = getLocalisation(getInseeCode($geoJson["city"]));
            if($coo !== null){
                $weather = getWeather($coo);
            }
            ?>
            <h2><?= $geoJson["city"] ?? "Ville introuvable" ?> : <?= $weather["weather"][0]["description"] ?? "" ?></h2>
            <div style="display: flex">
                <?php if($weather["weather"][0]["icon"] !== null): ?>
                <img src="https://openweathermap.org/img/wn/<?= $weather["weather"][0]["icon"] ?>@2x.png" alt="Illustration météo"/>
                <?php endif;?>
                <p style="font-size: 35px"><?= $weather["main"]["temp"] ?? ""?>°C</p>
            </div>
            <a class="see-more" href="meteo.php?city=<?= $geoJson["city"] ?>#selection">Voir plus</a>
        </div>
    </section>
<section class="default-section" style="margin: 10% auto 10% auto">
    <h2 class="h2-presentation">La météo à portée de clic</h2>
    <p style="font-size: 20px; margin-bottom: 20px">
        Bienvenue sur <strong>Ciel&amp;Temps</strong>, votre plateforme météo intelligente et interactive.
        Ce site vous permet de consulter en temps réel les <strong>prévisions météo</strong> selon votre ville.
        De plus grâce à notre système de <strong>géolocalisation</strong>, vous pouvez connaître immédiatement la météo là où vous vous trouvez.
    </p>
    <p style="font-size: 20px; margin-bottom: 20px">
        <strong>Qu’il pleuve des cordes ou qu’il fasse un temps radieux</strong>, la météo occupe une place essentielle dans
        <strong>notre quotidien.</strong>
        Elle influence <strong>nos déplacements, nos activités</strong>, et parfois même <strong>nos décisions.</strong> Comprendre le temps qu’il fait,
        c’est aussi mieux <strong>anticiper</strong> ce qui vient, <strong>s’adapter à son environnement</strong>, et développer une forme de vigilance face aux caprices du climat.
    </p>
    <p style="font-size: 20px; margin-bottom: 20px">
        Notre défi est de vous offrir un accès <strong>simple, clair</strong> et pratique aux <strong>informations
            météorologiques</strong> dont vous avez besoin, chaque jour.
    </p>
    <p style="font-size: 20px">
        Pour consulter les informations météorologiques, vous pouvez consulter notre <strong>carte interactive</strong> des régions de France ou
        indiquer la ville via notre <strong>barre de recherche</strong>. Par ailleurs il vous est possible d'accéder à diverses informations liées
        <strong>aux statistiques</strong>,
        de notre site.
    </p>
</section>
<?php
$img = getRandomImage();
$color = getColorFor($img);
?>
<section class="learn-more" style="background-color: <?=$color[0]?>" id="info">
    <h2 class="learn-more-title" style="color: <?=$color[1] ?>">Apprenez en plus sur la nature<br/>avec notre info météo</h2>
    <div>
        <img src= "<?= $img ?>" alt="image aléatoire"/>
        <div style="display: block; color: <?=$color[1] ?>">
            <?php printComment($img) ?>
        </div>
    </div>
</section>
<section class="default-section" id="faq">
    <h2 class="h2-question">Questions fréquemment posées</h2>
    <div class="question-parent">
        <div class="question-child">
            <div style="display: flex">
                <p class="question-symbole">📊</p>
                <div class="question">
                    <h3>Comment sont générées les données météo ?</h3>
                    <p>Les données proviennent d'une API météo professionnelle et sont mises à jour régulièrement.
                        Les prévisions reposent sur des modèles numériques complexes qui analysent l’évolution des masses d’air,
                        de la pression, de l’humidité et d’autres paramètres.</p>
                </div>
            </div>
            <div style="display: flex">
                <p class="question-symbole">🧭</p>
                <div class="question">
                    <h3>Puis-je voir la météo de ma ville ?</h3>
                    <p>
                        Oui, vous pouvez rechercher n’importe quelle ville
                        via notre barre de recherche ou activer la géolocalisation
                        pour obtenir les prévisions de votre position actuelle.
                    </p>
                </div>
            </div>
            <div style="display: flex">
                <p class="question-symbole">🌈</p>
                <div class="question">
                    <h3>Que signifient les icônes météo ?</h3>
                    <p>
                        Chaque icône représente une condition météo :
                        ☀️ pour le soleil, 🌧️ pour la pluie, ❄️ pour la neige, 🌩️ pour les orages, etc.
                        Elles vous permettent de comprendre rapidement la tendance du temps.
                    </p>
                </div>
            </div>
        </div>
            <div class="question-child">
                <div style="display: flex">
                    <p class="question-symbole">🔍</p>
                    <div class="question">
                        <h3>Quelle est la fiabilité des prévisions ?</h3>
                        <p>
                            Les prévisions sont très fiables à court terme (1 à 3 jours),
                            raisonnables jusqu'à 5 jours, mais deviennent progressivement incertaines au-delà,
                            en raison de la complexité des phénomènes atmosphériques.
                        </p>
                    </div>
                </div>
            <div style="display: flex">
                <p class="question-symbole">🎲</p>
                <div class="question">
                    <h3>Pourquoi certaines infos sont aléatoires sur la page d’accueil ?</h3>
                    <p>
                        Certaines données affichées sont volontairement aléatoires pour enrichir l'expérience
                        utilisateur.
                        Cela permet de découvrir des faits météo insolites ou éducatifs à chaque visite.
                    </p>
                </div>
            </div>
            <div style="display: flex">
                <p class="question-symbole">⚖️</p>
                <div class="question">
                    <h3>Pourquoi la météo affichée peut-elle être différente d’un site à l’autre ?</h3>
                    <p>
                        Les sites utilisent différentes sources de données et modèles de prévision.
                        Certains privilégient la précision locale, d’autres l’étendue géographique.
                        Cela peut entraîner de légères variations selon les plateformes.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include "includes/pageParts/footer.inc.php";
?>