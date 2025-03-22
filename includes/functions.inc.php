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
    $user_ip = "90.7.232.150";
    $geoData = @unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip&apiKey=2fa6e744-f73b-4f7e-b835-a9eae26360a2"));
    return $geoData;
}
?>
