<?php
/**
 * @file functionsWeather.php
 * Fonctions utile à la manipulation des données météorologique ou à leurs obtentions.
 */

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
    $organizedWeatherDay["cond"] = false;

    if (isset($_GET["city"]) && $_GET["city"] != null) {
        $coo = getLocalisation(getInseeCode($_GET["city"]));
        if($coo == null){
            return [["cond" => "introuvable"],["cond" => "introuvable"], ["cond" => "introuvable"]];
        }
        $weather = getWeather($coo);
        $organizedWeather = buildArrayWeather($weather);

        $dayWeather = getDayWeather($coo);
        $organizedWeatherDay = buildArrayWeatherDay($dayWeather);

        $weeklyWeather = getWeeklyWeather($coo);
        $organizedForecast = buildArrayForecast($weeklyWeather);

    }
    return [$organizedWeather, $organizedForecast, $organizedWeatherDay];
}

/**
 * Construit un tableau des météos d'un journée selon l'heure.
 * Elle organise les données pour faciliter leur accès.
 * @param array|null $dayWeather le tableau des informations trié par heure
 * @return array le tableau des informations organisé
 */
function buildArrayWeatherDay(?array $dayWeather) : array
{
    for($i=0; $i<5; $i++) {
        $hour = substr($dayWeather[$i]["dt_txt"], 10);
        $dayWeatherTab[$i]["hour"] = substr($hour, 0, -3);
        $dayWeatherTab[$i]["temp"] = $dayWeather[$i]["main"]["temp"];
        $dayWeatherTab[$i]["icon"] = $dayWeather[$i]["weather"][0]["icon"];
        $dayWeatherTab[$i]["desc"] = $dayWeather[$i]["weather"][0]["description"];
    }
    $dayWeatherTab["cond"] = true;
    return $dayWeatherTab;
}

/**
 * Construit un tableau de la météo d'aujourd'hui.
 * Elle organise les données pour faciliter leur accès.
 * @param array $weather le tableau des informations météo
 * @return array le tableau des informations organisé
 */
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

/**
 * Construit un tableau de la météo des prochains jours.
 * Elle organise les données pour faciliter leur accès.
 * @param array $forecast le tableau des prévisions météo des 4 prochains jours
 * @return array le tableau des informations organisé
 */
function buildArrayForecast(array $forecast): array
{
    $forecast = getSortForecast($forecast);
    for($i=0; $i<4; $i++){
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

/**
 * Convertit une date entré en date écris selon l'affichage français
 * @param array $date la date écris selon l'affichage américain
 * @return string la date écris selon l'affichage français
 */
function frenchDate(array $date): string
{
    $month = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    $monthNumber = $date[5].$date[6];
    return $date[8].$date[9]." ".$month[((int)$monthNumber)-1]." ".$date[0].$date[1].$date[2].$date[3];
}

/**
 * Trie les information des jours pour ne récupérer qu'un seul groupe d'information par journées
 * @param array $forecast les prévisions de tous les jours pour chaque heure
 * @return array le tableau trié
 */
function getSortForecast(array $forecast) : array
{
    $sortForecast = array();

    $day = date('d');
    foreach($forecast['list'] as $forecastItem){
        if((str_contains($forecastItem['dt_txt'], "12:00:00") && !str_contains($forecastItem['dt_txt'], "-".$day))){
            $sortForecast[] = $forecastItem;
        }
    }
    return $sortForecast;
}

/**
 * Récupère les données météo d'une journée avec l'API OpenWeatherMap
 * @param array|null $coo les coordonnées GPS du lieu dont on souhaite connaitre les données météo
 * @return mixed le tableau associatifs des données météorologiques
 */
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


/**
 * Récupère les prévisions météo d'une journée avec l'API OpenWeatherMap
 * @param array $coo les coordonnées GPS du lieu dont on souhaite connaitre les données météo
 * @return array|null le tableau associatifs des données météorologiques en ne conservant que les 4 premiers élements
 */
function getDayWeather(array $coo): ?array
{
    $token = "8aee9c708587f967d4842b3be0fcaf86";
    $url = "https://api.openweathermap.org/data/2.5/forecast?lat=".$coo[1]."&lon=".$coo[0]."&units=metric&lang=fr&appid=".$token;
    $data = file_get_contents($url);
    if($data == null){
        return null;
    }
    $json = json_decode($data, true);
    return getSortForecastDay($json);
}


/**
 * Trie le tableau des prévisions de la journée pour ne conserver que les prévisions des 5 prochaines heures
 * @param array $forecast le tableau des informations non triées
 * @return array le tableau trié
 */
function getSortForecastDay(array $forecast) : array
{
    $sortForecast = array();

    $i=0;
    foreach($forecast['list'] as $forecastItem){
        if($i<5){
            $sortForecast[] = $forecastItem;
            $i++;
        }
    }
    return $sortForecast;
}

/**
 * Récupère les prévisions météo d'une semaine avec l'API OpenWeatherMap
 * @param array $coo les coordonnées GPS dont on souhaite avoir les coordonées météo
 * @return mixed|null le tableau des prévisions des prochain jours
 */
function getWeeklyWeather(array $coo): mixed
{
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

/**
 * Retourne les coordonnées d'une ville via deux API du gouvernenment Français (dont une se secours) Geo API Gouv et API addresse gouv
 * @param string|null $insee le code insee de la ville dont on souhaite connaitre les coordonnées
 * @return mixed|null les coordonnées ou null si la ville n'est pas en France/n'existe pas
 */
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

/**
 * Retourne une chaine de caractère contenant l'affichage des données météorologique de la journée
 * @param array $dayWeatherTab la tableau des données météorologique
 * @return string le chaine de caractère à afficher
 */
function printWeatherDay(array $dayWeatherTab) : string
{
    $s = '<article style="text-align: center; justify-content: center" id="weatherDay"><h2 style="margin: 20px auto 20px auto">Prévisions de la journée</h2>';
    $s.='<div class="weatherDay">';
    for($i=0; $i<5; $i++){
        $s.="<div class='weatherDayItem'>";
        $s.="<p style='font-size: 20px'>".$dayWeatherTab[$i]["hour"]."</p>";
        $s.="<div class='temp'>";
        $s.='<img src="https://openweathermap.org/img/wn/'.$dayWeatherTab[$i]["icon"].'@2x.png" alt="Illustration de l\'heure"/>';
        $s.="<p style='font-size: 25px'>".$dayWeatherTab[$i]["temp"]."°C</p>";
        $s.="</div>";
        $s.="<p style='font-size: 20px'>".ucfirst($dayWeatherTab[$i]["desc"])."</p>";
        $s.="</div>";

    }
    $s.="</div>";
    $s.="</article>";
    return $s;
}

/**
 * Retourne une chaine de caractère contenant l'affichage des prévisions météorologique des 4 prochains jours
 * @param array $forecastTab le tableau des prévisions des 4 prochains jours
 * @return string le chaine de caractère à afficher
 */
function printForecastAll(array $forecastTab): string
{
    $s = '<section class="meteoSForecast" id="forecast">
        <h2>Prévisions</h2>
        <div class="forecast">';
    for($i = 0; $i < 4; $i++) {

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
              <img src="images/meteo/water.webp" alt="Illustration précipitation"/>
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
              <img src="images/meteo/road.webp" alt="Illustration visibilité"/>
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

/**
 * Retourne une chaine de caractère contenant l'affichage des prévisions météorologique d'un jour
 * @param array $forecastTab le tableau des prévisions des 4 prochains jours
 * @param int $i l'index du jours dont on souhaite connaitre la météo
 * @return string le chaine de caractère à afficher
 */
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
        <img src="images/meteo/water.webp" alt="Illustration précipitation"/>
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
        <img src="images/meteo/road.webp" alt="Illustration visibilité"/>
        <p style="font-size: 50px">'. $forecastTab[$i]["visibility"].'km</p>
        </div>
        <p style="font-size: 25px"><b>Conditions</b></p>
        <p style="font-size: 20px">'. $forecastTab[$i]["visibility-text"].'</p>
        </div>
        </div>';
    $s.="</div></section>";
    return $s;
}


