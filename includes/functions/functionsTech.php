<?php
declare(strict_types=1);
/**
 * Fonction qui renvoie un tableau (initialement en JSON) traité
 * Ce fichier JSON est issu de l'API de l'image du jour de la NASA
 * @return mixed le tableau à clés
 */
function getProcessedJSON(): mixed
{
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
function getPositionXML(): mixed
{
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $geoData = @unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip&apiKey=2fa6e744-f73b-4f7e-b835-a9eae26360a2"));
    return $geoData;
}

/**
 * Fonction qui renvoie un tableau (initialement en JSON) traité
 * Ce fichier XML est issu de l'API IPinfo permettant de localiser une adresse IP
 * @return mixed le tableau à clés
 */
function getPositionJSON(): mixed
{
    try{
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = "https://ipinfo.io/".$ip."/json?token=d167dc049c89d7";
    $geoData = file_get_contents($url);
    $resultat = json_decode($geoData, true);
    return $resultat;
    }
    catch(Throwable $e){
        $resultat = array();
        $resultat["city"] = null;
        return $resultat;
    }
}

/**
 * Fonction qui renvoie un tableau (initialement en XML) traité
 * Ce fichier XML est issu de l'API Whatismyip permettant de localiser une adresse IP
 * @return mixed le tableau à clés
 */
function getPositionXML2(): mixed
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = "https://api.whatismyip.com/ip-address-lookup.php?key="."fcddc989ff4010c22b4b37a67d100da1"."&input=".$ip.".235&output=xml";
    $geoData = @simplexml_load_string(file_get_contents($url));
    return $geoData;
}
