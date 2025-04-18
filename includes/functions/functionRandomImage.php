<?php
declare(strict_types=1);

function getRandomImage() : mixed
{
    $images = glob("images/meteo/imageAleatoire/new/*.webp");
    $index = array_rand($images);
    return $images[$index];
}

function getColorFor(string $img) : mixed
{
    $name = basename($img);
    switch ($name){
        case "clouds.webp" :
            return ['#d6c3af','#3c3c3c'];
        case "hot.webp" :
            return ['#a66f4a','#f3efe9'];
        case"rain.webp":
            return ["#4c5c4d","#e1e8dd"];
        case "snow.webp":
            return ["#cadbe5","#1f2c38"];
    }
    return ["#2b2f3a","#f0f0f0"]; //thunder
}

function printComment(string $img) : void
{
    $name = basename($img);
    switch ($name){
        case "clouds.webp" :
            echo "<p>☁️ Les nuages peuvent peser plusieurs tonnes.</p>
                  <p>Un nuage cumulus moyen contient plus de 500 tonnes d’eau,
                  <br>pourtant il flotte grâce à la légèreté de l’air chaud qui le porte.</p>
                  <p>➡️ Ce paradoxe est un excellent exemple de physique atmosphérique !</p>";
            break;
        case "hot.webp" :
            echo "<p>🌡️ La température la plus haute jamais mesurée est de 56,7 °C</p>
                  <p>Elle a été enregistrée en 1913 dans la Vallée de la Mort (Californie, USA).</p>
                  <p>➡️ Mais ce record est encore controversé par certains climatologues.</p>";
            break;
        case"rain.webp":
            echo "<p>🌦️ Les premières gouttes d’une averse sont souvent les plus grosses</p>
                  <p>Au début d'une pluie, les grosses gouttes tombent d'abord car elles se forment plus haut dans le nuage.
                  Ensuite, les gouttes deviennent plus petites et régulières.</p>";
            break;
        case "snow.webp":
            echo "<p>❄️ Il peut neiger même si la température est supérieure à 0°C</p>
                  <p>Tant que l’air est sec et froid en altitude, les flocons peuvent survivre jusqu’au sol, 
                  même si le thermomètre affiche +1 ou +2 °C au niveau du sol.</p>";
            break;
        default :
            echo "<p>⛈️ Les éclairs frappent plus souvent les gratte-ciels que les arbres.</p>
                  <p>Contrairement à la croyance populaire, les bâtiments élevés sont les premières cibles des éclairs.</p>
                  <p>➡️ Le Burj Khalifa est frappé des dizaines de fois par an.</p>"; //thunder
    }
}
