<?php
/**
 * Fonction qui renvoie un tableau (initialement en JSON) traité
 * Ce fichier JSON est issu de l'API de l'image du jour de la NASA
 * @return mixed le tableau à clés
 */
function getProcessedJSON(){
    $url = "https://api.nasa.gov/planetary/apod?api_key=bENUh7gZJEXONoWmWvNYYd0uOywRBb0Fl6GgVxj1";
    $data = file_get_contents($url);
    $result = json_decode($data, true);
    return $result;
}


/**
 * Fonction qui renvoie un tableau (initialement en XML) traité
 * Ce fichier XML est issu de l'API GeoPlugin permettant de localiser une adresse IP
 * @return mixed le tableau à clés
 */
function getPositionXML(){
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $geoData = @unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip&apiKey=2fa6e744-f73b-4f7e-b835-a9eae26360a2"));
    return $geoData;
}

/**
 * Fonction qui renvoie un tableau (initialement en JSON) traité
 * Ce fichier XML est issu de l'API IPinfo permettant de localiser une adresse IP
 * @return mixed le tableau à clés
 */
function getPositionJSON(){
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = "https://ipinfo.io/".$ip."/geo";
    $geoData = file_get_contents($url);
    $resultat = json_decode($geoData, true);
    return $resultat;
}

/**
 * Fonction qui renvoie un tableau (initialement en XML) traité
 * Ce fichier XML est issu de l'API Whatismyip permettant de localiser une adresse IP
 * @return mixed le tableau à clés
 */
function getPositionXML2(){
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = "https://api.whatismyip.com/ip-address-lookup.php?key="."fcddc989ff4010c22b4b37a67d100da1"."&input=".$ip.".235&output=xml";
    $geoData = simplexml_load_string(file_get_contents($url));
    return $geoData;
}

/**
 * Fonction qui lie le fichier csv des régions de France et qui renvoie la ligne dédié au nom de region mis en paramètre
 * Cette fonction sert à obtenir des informations spécifique sur une region sous forme de tableau
 * @param $regionName
 * @return array|false|void|null en fonction du résultat de la lecture de la fonction fgetcsv
 */
function readRegionCSV($regionName){
    $path = "csv/v_region_2024.csv";
    $fic = fopen($path, "r");
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if($line[5] == $regionName){
                return $line;
            }
        }
    }
    else{
        echo "Erreur : Ouverture impossible";
    }

}

/**
 * Cette fonction manipule un tableau contenant diverse information sur une region
 * Elle renvoie le code de la region
 * @param $region, obtenue via la fonction readRegionCSV
 * @return mixed, une chaine de caractère
 */
function getCodeRegion($region){
    return $region[0];
}

/**
 * Fonction qui lie le fichier csv des départements de France et qui renvoie un tableau dependant du code de la region
 * Cette fonction sert à obtenir le nom de tous les départements d'une region
 * @param $regionCode, code de la région dont on souhaite avoir les départements
 * @return array, tableau de chaine de caractère de tous les départements
 */
function getDepartments($regionCode){
    $path = "csv/v_departement_2024.csv";
    $fic = fopen($path, "r");
    $departments = array();
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if($line[1] == $regionCode){
                $departments[] = $line[6];
            }
        }
    }
    else{
        echo "Erreur : Ouverture impossible";
    }
    return $departments;
}

/**
 * Fonction qui lie que le fichier csv des départements ligne par ligne et compare son contenu avec celui du paramètre
 * Cette fonction sert à obtenir le code postale d'une région
 * @param $departmentName, le nom du départements dont on souhaite avoir le code postal.
 * @return mixed|null, une chaine de caractère | rien si la lecture a échoué
 */
function getDepartmentCode($departmentName){
    $path = "csv/v_departement_2024.csv";
    $fic = fopen($path, "r");
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if($line[6] == $departmentName){
                return $line[0];
            }
        }
    }
    return null;
}

/**
 * Fonction qui lie le fichier csv des villes de France ligne par ligne et compare son contenu avec celui du paramètre
 * Cette fonction sert à obtenir un tableau des villes d'un département
 * @param $departmentCode, le code postal du département dont on souhaite avoir les villes
 * @return array, un tableau de chaine de caractère
 */
function getCities($departmentCode){
    $path = "csv/communes-france-2025.csv";
    $fic = fopen($path, "r");
    $villes = array();
    if($fic !== false){
        while(($line = fgetcsv($fic, 10000, ",")) !== false){
            if($line[12] == $departmentCode){
                $villes[] = $line[6];
            }
        }
    }
    return $villes;
}

/**
 * Fonction qui construit un formulaire de sélection selon la taille d'un tableau et du type de son contenu
 * Cette fonction sert à obtenir un formulaire de sélection soit de départements, soit de villes
 * @param $tab, tableau contenant les noms à afficher
 * @param $type, le type d'information du tableau
 * @return string, le formulaire construit
 */
function buildSelect($tab, $type){
    if($type == "department"){
        $select = "<form method='GET' action='#selection'><br>
    <label for='".$type."'>Choisissez un "."département.</label><br><select name='".$type."'id='".$type."'>";
    }
    else{
        $select = "<form method='GET' action='#selection'><br>
    <label for='".$type."'>Choisissez une "."ville.</label><br><select name='".$type."'id='".$type."'>";
    }
    $tabLength = count($tab);
    for($i=0; $i<$tabLength; $i++){
        $select.="<br><option value='".htmlspecialchars($tab[$i])."'>".$tab[$i]."</option>";
    }
    $select.="<br></select><br>";
    $select.="<button type='submit'>Sélectionner</button>";
    return $select;
}

/**
 * Fonction utilisant l'API 'weatherAPI'
 * Elle sert à obtenir les informations météorologique d'une ville dans un tableau clé valeur
 * Elle lie le contenu de l'URL en JSON et le transforme en tableau associatif.
 * @param $city, le nom de la ville dont on souhaite avoir les informations météorologique
 * @return mixed, le tableau associatif des informations à l'heure actuelle
 */
function getCityUrl($city){
    $city = urlencode($city);
    $id = searchCityById($city);
    if($id!=""){
        $url = "http://api.weatherapi.com/v1/current.json?key=15585916836c45239de211822250104&q=id:".$id;
    }
    else {
        $coord = getCityLoc($city);
        $url = "http://api.weatherapi.com/v1/current.json?key=15585916836c45239de211822250104&q=" . $coord["latitude"] . "," . $coord["longitude"];
    }
    return $url;
}

function getCurrentWeather($url){
    $jsonData = file_get_contents($url);
    $tabResult = json_decode($jsonData, true);
    return $tabResult;
}

function searchCityById($city){
    $city = urlencode($city);
    $url = "http://api.weatherapi.com/v1/search.json?key=15585916836c45239de211822250104&q=".$city;
    $jsonData = file_get_contents($url);
    $tabResult = json_decode($jsonData, true);
    $id = "";
    $i=0;
    $found = false;
    while(!$found && $i<sizeof($tabResult) && !empty($tabResult) ){
        if($tabResult[$i]["country"] == "France"){
            $id.= $tabResult[$i]["id"];
            $found = true;
        }
        $i++;
    }
    return $id;
}

function getCityLoc($city){
    $city=getCityRealName($city);
    $url = "https://geo.api.gouv.fr/communes?nom=".$city."&fields=centre&format=json&geometry=centre";
    $jsonData = file_get_contents($url);
    $tabResult = json_decode($jsonData, true);
    $found = false;
    $i=0;
    while(!$found && $i<sizeof($tabResult)){
        if($tabResult[$i]["nom"] == $city){
            $coord["longitude"] = $tabResult[$i]["centre"]["coordinates"][0];
            $coord["latitude"] = $tabResult[$i]["centre"]["coordinates"][1];
            $found = true;
        }
        $i++;
    }
    return $coord;
}

function getCityRealName($cityName){
    $path = "csv/communes-france-2025.csv";
    $fic = fopen($path, "r");
    $cityName = strtolower($cityName);
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if(!empty($line[6]) && $line[6] == $cityName){
                return $line[2];
            }
        }
    }
}

function getRegion($cityName){
    $path = "csv/communes-france-2025.csv";
    $fic = fopen($path, "r");
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if(!empty($line[6]) && $line[6] == $cityName){
                return $line[11];
            }
        }
    }
}

/**
 * Récupère les prévisions météo sur 7 jours d'une ville avec WeatherAPI
 */
function getWeeklyWeather($url){
    $url = str_replace("current", "forecast", $url);
    $url .= "&days=7&lang=fr";
    $data = file_get_contents($url);
    $tabResult = json_decode($data, true);
    return $tabResult;
}

/**
 * Fonction traitant les différentes requêtes GET liée au choix de la region et du département.
 * Elle centralise la création du formulaire pour ne pas surcharger la page meteo.php
 * @return string|null le formulaire dépendamment de la requête
 */
function traitementGET(){
    $form = null;
    if (isset($_GET["region"]) && $_GET["region"] != null) {
        $region = readRegionCSV($_GET["region"]);
        $regionCode = getCodeRegion($region);
        $departments = getDepartments($regionCode);
        $form = buildSelect($departments, "department");
    }
    if (isset($_GET["department"]) && $_GET["department"] != null) {
        $departmentCode = getDepartmentCode($_GET["department"]);
        $cities = getCities($departmentCode);
        $form = buildSelect($cities, "city");
    }
    return $form;
}

/**
 * Fonction gérant les requête GET lié à la météo d'une ville.
 * Elle crée un tableau associatif regroupant les différentes information à afficher
 * @return array, le tableau des informations météo d'une ville choisie
 */
function traitementMeteo(){
    $weatherTab = array();
    $weatherTab["cond"] = false;
    if (isset($_GET["city"]) && $_GET["city"] != null) {
        $url = getCityUrl($_GET["city"]);
        $weather = getCurrentWeather($url);
        $weatherTab["cond"] = true;
        $weatherTab["city"] = $weather["location"]["name"];
        $weatherTab["region"] = $weather["location"]["region"];
        $weatherTab["deg"] = $weather["current"]["temp_c"];
        $weatherTab["feel"] = $weather["current"]["feelslike_c"];
        $weatherTab["day"] = $weather["current"]["is_day"];
        $weatherTab["rain"] = $weather["current"]["precip_mm"];
    }
    return $weatherTab;
}

/**
 * Incrémente et retourne un compteur de "hits" (nombre de visites ou rafraîchissements)
 * stocké dans un fichier texte 'hit.txt'. Crée le fichier s'il n'existe pas.
 * @return int le nombre de hit
 */
function refreshJson($cityName)
{
    $fic = "histo.json";
    if(!file_exists($fic)){
        createJson();
    }
    $data = file_get_contents("histo.json");
    $result = json_decode($data, true);
    if(!isset($result["villes"][$cityName])){
        $result["villes"][$cityName] = 1;
    }
    else{
        $result["villes"][$cityName]++;
    }
    $encode_result = json_encode($result, JSON_PRETTY_PRINT);
    file_put_contents("histo.json", $encode_result);
}

function createJson(){
    $content = array("villes");
    file_put_contents("histo.json", json_encode($content, JSON_PRETTY_PRINT));
}

function getRankingCitiesJson(){
    if(!file_exists("histo.json")){
        return;
    }
    $data = file_get_contents("histo.json");
    $result = json_decode($data, true);
    if(isset($result["villes"])){
        arsort($result["villes"]);
    }
    return $result["villes"];
}

function printRanking($ranking){
    $top7Faveeee = array_slice($ranking, 0, 5, true);
    $s = "<table class='normalTab'><tr><th>Classement</th><th>Ville</th><th>Nombre de consultations</th></tr>";
    $c = 1;
    foreach($top7Faveeee as $cle => $valeur){
        $s .= "<tr><td>$c</td><td>$cle</td><td>$valeur</td></tr>";
    }
    $s .= "</table>";
    echo $s;
}
?>