<?php
declare(strict_types=1);

include "functionsReadCsv.php";
include "functionsWeather.php";

function oldParameter(string $param) : ?string
{
    if($param == 'style'){
        return '?style='.urlencode($_GET["style"]);
    }
    if($param == "city"){
        return '?style='.urlencode($_GET["style"])."&city=".urlencode($_GET["city"]);
    }
    return null;
}
?>