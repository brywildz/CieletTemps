<?php
$title = "Prévisions";
$metaDesc ="Recherchez la météo de n'importe quelle ville française par nom ou code postal, avec des prévisions détaillées.";
$metaKeywords ="météo, recherche, ville, code postal, prévisions météo, localisation, Ciel et Temps";
$css = "search.css";
$css2 = "meteo.css";
include "includes/functions/functionsGlobal.php";
include "includes/functions/functionRanking.php";

if (isset($_GET["city"]) && $_GET["city"] != null) {
    setcookie("derniere_ville", $_GET["city"], time() + 60 * 60 * 24 * 7);
}
include "includes/pageParts/header.inc.php";
?>

<section class="search-section">
        <h1>🌤️ Indiquez le nom d'une ville</h1>

    <form class="search-form" action="search.php" method="get">
        <label for="city" class="visually-hidden">Rechercher une ville</label>
        <input type="text" name="city" id="city" class="search-input" placeholder="Rechercher..." />
        <button type="submit" class="search-button">➔</button>
    </form>
    <?php if (isset($_COOKIE["derniere_ville"]) && $_COOKIE["derniere_ville"] != null && !isset($_GET["city"])):?>
        <?php $city = $_COOKIE["derniere_ville"]; ?>
        <div class="last-city" style="text-align: right">
            <h2>Vu récemment : <?= $city ?></h2>
            <a class="see-more" href="search.php?city=<?= $city ?>#selection">Voir la météo</a>
        </div>
    <?php endif; ?>
    <?php
    $weatherTab = traitementMeteo();
    $weatherAndForecast = traitementMeteo();
    $weatherTab = $weatherAndForecast[0];
    $forecastTab = $weatherAndForecast[1];
    ?>

    <?php if ($weatherTab["cond"] && $forecastTab["cond"]): ?>
    <?php refreshCsv($weatherTab["city"]) ?>
    <section class="meteoSearch" id="weather">
        <h3 style="text-align: left; color: white"><b>Météo <?= $_GET["city"] ?>
                : <?= ucfirst($weatherTab["desc"]) ?></b></h3>
        <div class="meteo-in">

            <div class="meteo-info-degre">

                <div style="display: flex">
                    <img style=
                         "flex-shrink: 0; flex-grow: 0; height: auto; width: auto;"
                         src="https://openweathermap.org/img/wn/<?= $weatherTab["img"] ?>@2x.png"
                         alt="Illustration météo"/>
                    <p style="font-size: 40px"><?= $weatherTab["deg"] ?>°C</p>
                </div>
                <p style="font-size: 20px">🎯 Ressenti <?= $weatherTab["feel"] ?> </p>
                <p>❄️ Min : <?= $weatherTab["min"] ?>°C</p>
                <p>🔥 Max : <?= $weatherTab["max"] ?>°C</p>
            </div>
            <img src="images/meteo/separation-line.webp" alt="trait"/>
            <div class="meteo-info">
                <p style="font-size: 25px">💨 Vent : <?= $weatherTab["wind"] ?> m/s</p>
                <p style="font-size: 25px">☁️ Nuages : <?= $weatherTab["clouds"] ?>%</p>
                <p style="font-size: 25px">💧 Humidité : <?= $weatherTab["humidity"] ?>%</p>
            </div>
        </div>
        <div class="forecast-ask">
            <h4>Voir les prévisions ?</h4>
            <form action="meteo.php?city=<?= $_GET['city'] ?>#forecast" method="get">
                <label>
                    <select name="day">
                        <option value="">Sélectionner une date ▾</option>
                        <option value="0"><?= $forecastTab[0]["date"] ?></option>
                        <option value="1"><?= $forecastTab[1]["date"] ?></option>
                        <option value="2"><?= $forecastTab[2]["date"] ?></option>
                        <option value="3"><?= $forecastTab[3]["date"] ?></option>
                        <option value="4"><?= $forecastTab[4]["date"] ?></option>
                        <option value="all">5 prochains jours</option>
                    </select>
                    <input type="hidden" name="city" value="<?= $_GET['city'] ?>"/>
                </label>
                <button type="submit">Valider</button>
            </form>
        </div>

    </section>

<?php endif; ?>

<?php if(isset($_GET['day'])){
    $day = $_GET['day'];
    if($day == "all"){
        echo printForecastAll($forecastTab);
    }
    else{
        echo printForecast($forecastTab, $day);
    }
}?>
</section>

<?php
include "includes/pageParts/footer.inc.php";
?>
