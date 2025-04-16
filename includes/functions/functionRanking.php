<?php
declare(strict_types=1);
/**
 * Incrémente et retourne un compteur de "hits" (nombre de visites ou rafraîchissements)
 * stocké dans un fichier CSV 'ranking.csv'. Crée le fichier s'il n'existe pas.
 */
function refreshCsv($cityName): void
{
    $fic = "csv/ranking.csv";
    if(!file_exists($fic)){
        createCsv();
    }
    $data = [];
    $handleRead = fopen($fic, "r");
    $found = false;
    if($handleRead !== false) {
        while (($line = fgetcsv($handleRead, 1000, ",")) !== false) {
            if($line[0] == $cityName){
                $found = true;
                $line[1]++;
            }
            $data[] = $line;
        }
    }
    fclose($handleRead);
    if(!$found){
        $newLine = [$cityName, 1];
        $data[] = $newLine;
    }
    $handleWrite = fopen($fic, "w");
    foreach ($data as $line){
        fputcsv($handleWrite, $line);
    }
    fclose($handleWrite);
}


function createCsv(): void
{
    $content = ["Ville", "Valeur"];
    $file = "csv/ranking.csv";
    $handle = fopen($file, "w");
    if($handle !== false){
        fputcsv($handle, $content);
    }
    fclose($handle);
}

function getRankingCitiesCsv() : ?array{
    if(!file_exists("csv/ranking.csv")){
        return null;
    }
    $rankingTab = [];
    $file = "csv/ranking.csv";
    $i=0;
    if(($handle = fopen($file, "r")) !== false){
        fgetcsv($handle, 1000, ","); //éliminer l'entête
        while(($line = fgetcsv($handle, 1000, ",")) !== false){
            $rankingTab[$line[0]] = $line[1];
            $i++;
        }
    }
    arsort($rankingTab);
    return $rankingTab;
}



function printRanking($ranking): void
{
    $top7Faveeee = array_slice($ranking, 0, 5, true);
    $s = "<table class='normalTab'><tr><th>Classement</th><th>Ville</th><th>Nombre de consultations</th></tr>";
    $c = 1;
    foreach($top7Faveeee as $cle => $valeur){
        $s .= "<tr><td>$c</td><td>$cle </td><td>$valeur</td></tr>";
        $c++;
    }
    $s .= "</table>";
    echo $s;
}
