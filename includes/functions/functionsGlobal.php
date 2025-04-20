<?php
/**
 * @file functionGlobal.php
 * Fonctions diverses
 */

declare(strict_types=1);

include "functionsReadCsv.php";
include "functionsWeather.php";


/**
 * Supprime les cookies présents dans le navigateur de l'utilisateurs pour notre site
 * @return void
 */
function deleteCookies(): void
{
    foreach ($_COOKIE as $name => $value) {
        setcookie($name, '', time() - 3600, "/");
    }
}

/**
 * Incrémente et retourne un compteur de "hits" (nombre de visites ou rafraîchissements)
 * stocké dans un fichier texte 'hit.txt'. Crée le fichier s'il n'existe pas.
 * @return int le nombre de hit
 */
function hitAndRefresh(bool $refresh): int
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? "0.0.0.0";
    $fic = "hit.txt";
    if(!file_exists($fic)){
        file_put_contents($fic, $ip."/");
        return 1;
    }
    $content = file_get_contents($fic);
    $ips = array_filter(explode("/", $content));
    if(!in_array($ip, $ips) && $refresh) {
        file_put_contents($fic, $ip."/", FILE_APPEND);
    }
    $hitNbr = count($ips);
    return $hitNbr;
}
?>