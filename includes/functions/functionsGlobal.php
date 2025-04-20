<?php
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
?>