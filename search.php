<?php
$css = "search.css";
$css2 = "meteo.css";
include "includes/functions/functions.inc.php";
include "includes/functions/functionRanking.php";

if (isset($_GET["city"]) && $_GET["city"] != null) {
    setcookie("derniere_ville", $_GET["city"], time() + 60 * 60 * 24 * 7);
}
$title = "Prévisions";
include "includes/pageParts/header.inc.php";
?>

<section class="search-section">
    <h1>🌤️ Indiquez le nom d'une ville</h1>
        <form class="search-div" action="search.php#result" method="get">
            <label>
                Votre ville :
                <input class="search-bar" type="text" name="city"
                       value="<?php if(isset($_COOKIE["derniere_ville"])){ echo $_COOKIE["derniere_ville"];} ?>"
                placeholder="ex : Paris"/>
            </label>
            <button class="searchButton" href="#">
                    🔍 Rechercher
            </button>
            <!--<input type="submit" value="Valider"/>-->
        </form>

    <?php
    $weatherTab = traitementMeteo();

    ?>

    <?php if ($weatherTab["cond"]):?>
        <?php refreshCsv($weatherTab["city"])?>

        <div class="meteo" id="result" style="margin-top: 50px; width: 1000px">
            <p><b>Météo <?= $_GET["city"] ?> : <?=ucfirst($weatherTab["desc"])?></b></p>
            <div class="meteo-in">

                <div class="meteo-info-degre">

                    <div style="display: flex">
                        <img style=
                             "flex-shrink: 0; flex-grow: 0; height: auto; width: auto;"
                             src="https://openweathermap.org/img/wn/<?= $weatherTab["img"] ?>@2x.png"
                             alt="Illustration météo"/>
                        <p style="font-size: 40px"><?= $weatherTab["deg"] ?>°C</p>
                    </div>
                    <p style="font-size: 20px">🎯 Ressenti <?=$weatherTab["feel"]?> </p>
                    <p>❄️ Min : <?= $weatherTab["min"]?>°C</p>
                    <p>🔥 Max : <?= $weatherTab["max"]?>°C</p>
                </div>
                <img src="images/linee.PNG" alt="trait"/>
                <div class="meteo-info">
                    <p style="font-size: 25px">💨 Vent : <?=$weatherTab["wind"]?> m/s</p>
                    <p style="font-size: 25px">☁️ Nuages : <?= $weatherTab["clouds"] ?>%</p>
                    <p style="font-size: 25px">💧 Humidité : <?= $weatherTab["humidity"] ?>%</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

</section>
