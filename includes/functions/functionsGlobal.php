<?php
declare(strict_types=1);

include "functionsReadCsv.php";
include "functionsWeather.php";

function deleteCookies(): void
{
    foreach ($_COOKIE as $name => $value) {
        setcookie($name, '', time() - 3600, "/");
    }
}
?>