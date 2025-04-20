<?php
/**
 * @file functionRanking.php
 * Fonctions gérant le classement des villes les plus consultées du site
 */

declare(strict_types=1);
/**
 * Rafraichit le fichier serveur des villes consultés.
 *
 * Incrémente la ville consulté ou crée une nouvelle valeur
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

/**
 * Crée le fichiers des villes consultées si il n'existe pas
 * @return void
 */
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

/**
 * Retourne le classement des villes les plus consultés du site.
 * Parcours le le fichiers csv des villes les plus consulté et crée un tableau trié dans l'ordre croissant.
 * @return array|null
 */
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