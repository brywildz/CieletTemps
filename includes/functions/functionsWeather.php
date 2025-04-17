<?php

declare(strict_types=1);

function getLocalisation(string $insee){
    $url1 = "https://geo.api.gouv.fr/communes/".$insee."?fields=nom,centre";
    $context = stream_context_create([
        "http" =>
            ["timeout" => 1]
    ]); //Pour corriger le problème ayant commencé le 17/04 (l'API ne fonctionne plus pour tout le monde)
    $data = @file_get_contents($url1, false ,$context);
    if($data === false){
        $city_cp = getVille_Cp($insee);
        $url2 = "https://api-adresse.data.gouv.fr/search/?q=".urlencode($city_cp)."&limit=1";
        $data = file_get_contents($url2);
        $result = json_decode($data, true);
        return $result["features"][0]["geometry"]["coordinates"];
    }
    $result = json_decode($data, true);
    return $result["centre"]["coordinates"];
}

function getWeather(string $insee) : mixed
{
    $coo = getLocalisation($insee);
    $token = "8aee9c708587f967d4842b3be0fcaf86";
    $url = "https://api.openweathermap.org/data/2.5/weather?lat=".$coo[1]."&lon=".$coo[0]."&units=metric&lang=fr&appid=".$token;
    $data = file_get_contents($url);
    if($data == null){
        return null;
    }
    $result = json_decode($data, true);
    return $result;
}

function getWeeklyWeather(){
    
}

function getJsonAnswer(string $url, string $token) : mixed
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept : application/json', 'Authorization: Bearer '.$token));
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $answer = curl_exec($ch);
    if($answer !== false){
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    }
    curl_close($ch);
    if($answer !== false && $status == 200){
        return $answer;
    }
    else{
        return null;
    }

}


