<?php

declare(strict_types=1);

/**
 * Fonction traitant les différentes requêtes GET liée au choix de la region et du département.
 * Elle centralise la création du formulaire pour ne pas surcharger la page meteo.php
 * @return string|null le formulaire dépendamment de la requête
 */
function traitementGET(): ?string
{
    $form = null;
    if (isset($_GET["region"]) && $_GET["region"] != null) {
        $region = getRegion($_GET["region"]);
        $departments = getDepartments($region["postal"]);
        $form = buildSelect($departments, "department");
    }
    if (isset($_GET["department"]) && $_GET["department"] != null) {
        $cities = getCities($_GET["department"]);
        $form = buildSelect($cities, "city");
    }
    return $form;
}

/**
 * Fonction gérant les requête GET lié à la météo d'une ville.
 * Elle crée un tableau associatif regroupant les différentes information à afficher
 * @return array, le tableau des informations météo d'une ville choisie
 */
function traitementMeteo(): array
{
    $organizedWeather = array();
    $organizedForecast = array();

    $organizedWeather["cond"] = false;
    $organizedForecast["cond"] = false;

    if (isset($_GET["city"]) && $_GET["city"] != null) {
        $coo = getLocalisation(getInseeCode($_GET["city"]));
        if($coo == null){
            return [["cond" => "introuvable"],["cond" => "introuvable"]];
        }
        $weather = getWeather($coo);
        $organizedWeather = buildArrayWeather($weather);

        $weeklyWeather = getWeeklyWeather($coo);
        $organizedForecast = buildArrayForecast($weeklyWeather);

    }
    return [$organizedWeather, $organizedForecast];
}

function buildArrayWeather(array $weather): array{
    $weatherTab["cond"] = true;
    $weatherTab["city"] = $weather["name"];
    $weatherTab["img"] = $weather["weather"][0]["icon"];
    $weatherTab["desc"] = $weather["weather"][0]["description"];
    $weatherTab["deg"] = $weather["main"]["temp"];
    $weatherTab["feel"] = $weather["main"]["feels_like"];
    $weatherTab["min"] = $weather["main"]["temp_min"];
    $weatherTab["max"] = $weather["main"]["temp_max"];
    $weatherTab["clouds"] = $weather["clouds"]["all"];
    $weatherTab["wind"] = $weather["wind"]["speed"];
    //$weatherTab["wind_dir"] = $weather["current"]["wind_dir"];
    $weatherTab["humidity"] = $weather["main"]["humidity"];
    return $weatherTab;
}

function buildArrayForecast(array $forecast): array
{
    $forecast = getSortForecast($forecast);
    for($i=0; $i<5; $i++){
        $date = str_split($forecast[$i]["dt_txt"]);
        $forecastTab[$i]["date"] = frenchDate($date);
        $forecastTab[$i]["img"] = $forecast[$i]["weather"][0]["icon"];
        $forecastTab[$i]["desc"] = $forecast[$i]["weather"][0]["description"];
        $forecastTab[$i]["deg"] = $forecast[$i]["main"]["temp"];
        $forecastTab[$i]["feel"] = $forecast[$i]["main"]["feels_like"];
        $forecastTab[$i]["min"] = $forecast[$i]["main"]["temp_min"];
        $forecastTab[$i]["max"] = $forecast[$i]["main"]["temp_max"];
        $forecastTab[$i]["clouds"] = $forecast[$i]["clouds"]["all"];
        $forecastTab[$i]["wind"] = $forecast[$i]["wind"]["speed"];
        //$forecastTab[$i]["wind_dir"] = $forecast[$i]["current"]["wind_dir"];
        $forecastTab[$i]["humidity"] = $forecast[$i]["main"]["humidity"];
        $forecastTab[$i]["rain_prob"]= $forecast[$i]["pop"]*100;
        $forecastTab[$i]["pressure"]= $forecast[$i]["main"]["pressure"];
        $forecastTab[$i]["visibility"] = $forecast[$i]["visibility"]/1000;
        if($forecastTab[$i]["visibility"]>=10){
            $forecastTab[$i]["visibility-text"] = "Visibilité excellente, ciel dégagé.";
        }
        else if($forecastTab[$i]["visibility"]>6){
            $forecastTab[$i]["visibility-text"] = "Bonne visibilité, conditions favorables.";
        }
        else if($forecastTab[$i]["visibility"]>3){
            $forecastTab[$i]["visibility-text"] = "Visibilité moyenne, légère brume possible.";
        }
        else if($forecastTab[$i]["visibility"]>1){
            $forecastTab[$i]["visibility-text"] = "Faible visibilité, soyez vigilant.";
        }
        else if($forecastTab[$i]["visibility"]<1){
            $forecastTab[$i]["visibility-text"] = "Très faible visibilité, conditions difficiles.";
        }
    }
    $forecastTab["cond"] = true;
    return $forecastTab;
}

function frenchDate(array $date): string
{
    $month = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    $monthNumber = $date[5].$date[6];
    return $date[8].$date[9]." ".$month[(int)$monthNumber]." ".$date[0].$date[1].$date[2].$date[3];
}

function getSortForecast(array $forecast) : array
{
    $sortForecast = array();

    foreach($forecast['list'] as $forecastItem){
        if((str_contains($forecastItem['dt_txt'], "12:00:00"))){
            $sortForecast[] = $forecastItem;
        }
    }
    return $sortForecast;
}

function getWeather(?array $coo) : mixed
{
    if($coo === null){
        return null;
    }
    $token = "8aee9c708587f967d4842b3be0fcaf86";
    $url = "https://api.openweathermap.org/data/2.5/weather?lat=".$coo[1]."&lon=".$coo[0]."&units=metric&lang=fr&appid=".$token;
    $data = file_get_contents($url);
    if($data == null){
        return null;
    }
    return json_decode($data, true);
}

function getWeeklyWeather(array $coo){
    $token = "8aee9c708587f967d4842b3be0fcaf86";
    $url = "https://api.openweathermap.org/data/2.5/forecast?lat=".$coo[1]."&lon=".$coo[0]."&units=metric&lang=fr&appid=".$token;
    $data = file_get_contents($url);
    if($data == null){
        return null;
    }
    return json_decode($data, true);
}

/**
 * Fonction qui construit un formulaire de sélection selon la taille d'un tableau et du type de son contenu
 * Cette fonction sert à obtenir un formulaire de sélection soit de départements, soit de villes
 * @param $tab, tableau contenant les noms à afficher
 * @param $type, le type d'information du tableau
 * @return string, le formulaire construit
 */
function buildSelect($tab, $type): string
{
    if($type == "department"){
        $select = "<form method='GET' action='meteo.php#weather' class='form-meteo'>
    <label style='font-size: 20px' for='".$type."'>Choisissez un département.</label>
    <select class='custom-select' name='".$type."' id='".$type."'>
    ";
    }
    else{
        $select = "<form method='GET' action='meteo.php#weather' class='form-meteo'>
    <label style='font-size: 20px' for='".$type."'>Choisissez une ville.</label>
    <select class='custom-select' name='".$type."' id='".$type."'>
    ";
    }
    $tabLength = count($tab);
    for($i=0; $i<$tabLength; $i++){
        $city = htmlspecialchars($tab[$i][1]);
        $postal = htmlspecialchars($tab[$i][0]);
        $select.='<option value="' . $city . '">' . $postal . " - ". $city ."</option>
        ";
    }
    $select.="</select>
    ";
    $select.="<button class='search-button' type='submit'>Sélectionner</button>
    </form>";
    return $select;
}

function getLocalisation(?string $insee){
    if($insee === null){
        return null;
    }
    try {
    $url1 = "https://geo.api.gouv.fr/communes/".$insee."?fields=nom,centre";
    $context = stream_context_create([
        "http" =>
            ["timeout" => 1]
    ]); //Pour corriger le problème ayant commencé le 17/04 (l'API ne fonctionne plus pour tout le monde)
    $data = @file_get_contents($url1, false ,$context);
    if($data === false){
        $city_cp = getVille_Cp($insee);
        if($city_cp != null){
            return null;
        }
        $url2 = "https://api-adresse.data.gouv.fr/search/?q=".@urlencode($city_cp)."&limit=1";
        $data = @file_get_contents($url2);
        $result = json_decode($data, true);
        return $result["features"][0]["geometry"]["coordinates"];
    }
    $result = json_decode($data, true);
    return $result["centre"]["coordinates"];
    }
    catch (Throwable $c){
        return null;
    }
}

function printForecastAll(array $forecastTab): string
{
    $s = '<section class="meteoSForecast" id="forecast">
        <h2>Prévisions</h2>
        <div class="forecast">';
    for($i = 0; $i < 5; $i++) {

        $s.='<h3 class="h3-day">Météo du '. $forecastTab[$i]["date"].'</h3>
             <div class="forecast-day">
             <div class="forecast-item">
              <h4>TEMPERATURE</h4>
              <div style="display: flex">
              <img src="https://openweathermap.org/img/wn/'. $forecastTab[$i]["img"].'@2x.png" alt="Illustration météo"/>
              <p style="font-size: 50px">'. $forecastTab[$i]["deg"].'°</p>
              </div>
              <div class="sun-details">
              <div>
              <p class="icon">🎯</p>
              <div style="display: block; margin-left: 8px;">
              <p><b>'. $forecastTab[$i]["feel"].'°</b></p>
              <p style="font-size: 16px">Ressenti</p>
              </div>

              </div>
              <div>
              <p class="icon">🔥</p>
              <div style="display: block; margin-left: 8px;">
              <p> <b>'. $forecastTab[$i]["max"].'°</b></p>
              <p style="font-size: 16px">Maximum</p>
              </div>
              </div>
              <div>
              <p class="icon">💬</p>
              <div style="display: block; margin-left: 8px;">
              <p><b>'. ucfirst($forecastTab[$i]["desc"]).'</b></p>
              <p style="font-size: 16px">Commentaire</p>
              </div>

              </div>
              <div>
              <p class="icon">❄️</p>
              <div style="display: block; margin-left: 8px;">
              <p> <b>'. $forecastTab[$i]["min"].'°</b></p>
              <p style="font-size: 16px">Minimum</p>
              </div>
              </div>
              </div>
              </div>

              <img src="images/meteo/separation-line.webp" alt="trait"/>

              <div class="forecast-item">
              <h4>PRECIPITATION</h4>
              <div style="display: flex">
              <img src="images/meteo/water.webp" alt="Illustration météo"/>
              <p style="font-size: 50px">'. $forecastTab[$i]["rain_prob"].'%</p>
              </div>
              <div class="sun-details">
              <div>
              <p class="icon">☁️</p>
              <div style="display: block; margin-left: 8px;">
              <p><b>'. $forecastTab[$i]["clouds"].'%</b></p>
              <p style="font-size: 16px">Nuages</p>
              </div>

              </div>
              <div>
              <p class="icon">💨</p>
              <div style="display: block; margin-left: 8px;">
              <p> <b>'. $forecastTab[$i]["wind"].'m/s</b></p>
              <p style="font-size: 16px">Vent</p>
              </div>
              </div>
              <div>
              <p class="icon">💧</p>
              <div style="display: block; margin-left: 8px;">
              <p><b>'. $forecastTab[$i]["humidity"].'%</b></p>
              <p style="font-size: 16px">Humidité</p>
              </div>

              </div>
              <div>
              <p class="icon">🌡️</p>
              <div style="display: block; margin-left: 8px;">
              <p> <b>'. $forecastTab[$i]["pressure"].'hPa</b></p>
              <p style="font-size: 16px">Pression</p>
              </div>
              </div>
              </div>
              </div>
              <img src="images/meteo/separation-line.webp" alt="trait"/>

              <div class="forecast-item">
              <h4>VISIBILITÉ</h4>
              <div style="display: flex">
              <img src="images/meteo/road.webp" alt="Illustration météo"/>
              <p style="font-size: 50px">'. $forecastTab[$i]["visibility"].'km</p>
              </div>
              <p style="font-size: 25px"><b>Conditions</b></p>
              <p style="font-size: 20px">'. $forecastTab[$i]["visibility-text"].'</p>
              </div>
              </div>';
            }
    $s.="</div></section>";
    return $s;
}

function printForecast(array $forecastTab, int $i): string
{
    $s = '<section class="meteoSForecast" id="forecast">
        <h2>Prévisions</h2>
        <div class="forecast">';
    $s.='<h3 class="h3-day">Météo du '. $forecastTab[$i]["date"].'</h3>
         <div class="forecast-day">
        <div class="forecast-item">
        <h4>TEMPERATURE</h4>
        <div style="display: flex">
        <img src="https://openweathermap.org/img/wn/'. $forecastTab[$i]["img"].'@2x.png" alt="Illustration météo"/>
        <p style="font-size: 50px">'. $forecastTab[$i]["deg"].'°</p>
        </div>
        <div class="sun-details">
        <div>
        <p class="icon">🎯</p>
        <div style="display: block; margin-left: 8px;">
        <p><b>'. $forecastTab[$i]["feel"].'°</b></p>
        <p style="font-size: 16px">Ressenti</p>
        </div>

        </div>
        <div>
        <p class="icon">🔥</p>
        <div style="display: block; margin-left: 8px;">
        <p> <b>'. $forecastTab[$i]["max"].'°</b></p>
        <p style="font-size: 16px">Maximum</p>
        </div>
        </div>
        <div>
        <p class="icon">💬</p>
        <div style="display: block; margin-left: 8px;">
        <p><b>'. ucfirst($forecastTab[$i]["desc"]).'</b></p>
        <p style="font-size: 16px">Commentaire</p>
        </div>

        </div>
        <div>
        <p class="icon">❄️</p>
        <div style="display: block; margin-left: 8px;">
        <p> <b>'. $forecastTab[$i]["min"].'°</b></p>
        <p style="font-size: 16px">Minimum</p>
        </div>
        </div>
        </div>
        </div>

        <img src="images/meteo/separation-line.webp" alt="trait"/>

        <div class="forecast-item">
        <h4>PRECIPITATION</h4>
        <div style="display: flex">
        <img src="images/meteo/water.webp" alt="Illustration météo"/>
        <p style="font-size: 50px">'. $forecastTab[$i]["rain_prob"].'%</p>
        </div>
        <div class="sun-details">
        <div>
        <p class="icon">☁️</p>
        <div style="display: block; margin-left: 8px;">
        <p><b>'. $forecastTab[$i]["clouds"].'%</b></p>
        <p style="font-size: 16px">Nuages</p>
        </div>

        </div>
        <div>
        <p class="icon">💨</p>
        <div style="display: block; margin-left: 8px;">
        <p> <b>'. $forecastTab[$i]["wind"].'m/s</b></p>
        <p style="font-size: 16px">Vent</p>
        </div>
        </div>
        <div>
        <p class="icon">💧</p>
        <div style="display: block; margin-left: 8px;">
        <p><b>'. $forecastTab[$i]["humidity"].'%</b></p>
        <p style="font-size: 16px">Humidité</p>
        </div>

        </div>
        <div>
        <p class="icon">🌡️</p>
        <div style="display: block; margin-left: 8px;">
        <p> <b>'. $forecastTab[$i]["pressure"].'hPa</b></p>
        <p style="font-size: 16px">Pression</p>
        </div>
        </div>
        </div>
        </div>
        <img src="images/meteo/separation-line.webp" alt="trait"/>

        <div class="forecast-item">
        <h4>VISIBILITÉ</h4>
        <div style="display: flex">
        <img src="images/meteo/road.webp" alt="Illustration météo"/>
        <p style="font-size: 50px">'. $forecastTab[$i]["visibility"].'km</p>
        </div>
        <p style="font-size: 25px"><b>Conditions</b></p>
        <p style="font-size: 20px">'. $forecastTab[$i]["visibility-text"].'</p>
        </div>
        </div>';
    $s.="</div></section>";
    return $s;
}


