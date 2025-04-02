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

function getCodeRegion($region){
    return $region[0];
}

function getDepartments($regionCode){
    $path = "csv/v_departement_2024.csv";
    $fic = fopen($path, "r");
    $departments = array();
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if($line[1] == $regionCode){
                $departments[] = $line[4];
            }
        }
    }
    else{
        echo "Erreur : Ouverture impossible";
    }
    return $departments;
}

function getDepartmentCode($departmentName){
    $path = "csv/v_departement_2024.csv";
    $fic = fopen($path, "r");
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if($line[4] == $departmentName){
                return $line[0];
            }
        }
    }
    return null;
}

function getCities($departmentCode){
    $path = "csv/v_ville_2024.csv";
    $fic = fopen($path, "r");
    $villes = array();
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if($line[7] == $departmentCode){
                $villes[] = $line[1];
            }
        }
    }
    return $villes;
}

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

function getWeather($city){
    $city = urlencode($city);
    $url = "http://api.weatherapi.com/v1/current.json?key=15585916836c45239de211822250104&q=".$city;
    $jsonData = file_get_contents($url);
    $tabResult = json_decode($jsonData, true);
    return $tabResult;
}
?>
