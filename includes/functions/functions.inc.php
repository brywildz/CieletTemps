<?php
declare(strict_types=1);

include "functionsReadCsv.php";
include "functionsWeather.php";


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
    $weatherTab = array();
    $weatherTab["cond"] = false;
    if (isset($_GET["city"]) && $_GET["city"] != null) {
        $weather = getWeather(getInseeCode($_GET["city"]));
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
    }
    return $weatherTab;
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
        $select = "<form method='GET' action='#selection'><br>
    <label for='".$type."'>Choisissez un "."département.</label><br><select class='custom-select' name='".$type."'id='".$type."'>";
    }
    else{
        $select = "<form method='GET' action='#selection'><br>
    <label for='".$type."'>Choisissez une "."ville.</label><br><select class='custom-select' name='".$type."'id='".$type."'>";
    }
    $tabLength = count($tab);
    for($i=0; $i<$tabLength; $i++){
        $city = htmlspecialchars($tab[$i][1]);
        $postal = htmlspecialchars($tab[$i][0]);
        $select.='<br><option value="' . $city . '">' . $postal . " - ". $city ."</option>";
    }
    $select.="<br></select><br>";
    $select.="<button type='submit'>Sélectionner</button>";
    return $select;
}

function getIndicePluie($n){
    if($n == 0){
        echo "0/5";
    }
    else if($n > 0.1 && $n < 1){
        echo "1/5";
    }
    else if($n > 1 && $n < 5){
        echo "2/5";
    }
    else if($n > 5 && $n < 20){
        echo "3/5";
    }
    else if($n > 20 && $n < 50){
        echo "4/5";
    }
    else{
        echo "5/5";
    }
}

function chiffreAleatoire(): int
{
    $r = 3;
    while($r == 3 || $r == 1){
    $r = rand(1,9);
    }
    return $r;
}
?>