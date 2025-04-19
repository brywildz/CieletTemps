<?php

declare(strict_types=1);

/**
 * Fonction qui lie le fichier csv des régions de France et qui renvoie la ligne dédié au nom de region mis en paramètre
 * Cette fonction sert à obtenir des informations spécifique sur une region sous forme de tableau
 * @param $regionName
 * @return array|false|void|null en fonction du résultat de la lecture de la fonction fgetcsv
 */
function getRegion($regionName){
    $path = "csv/regions.csv";
    $fic = fopen($path, "r");
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if($line[5] == $regionName){
                return ["postal" => $line[0], "name" => $line[5]];
            }
        }
    }
    else{
        echo "Erreur : Ouverture impossible";
    }
}

function getDepartments(string $regionCode) : array
{
    $path = "csv/departements.csv";
    $fic = fopen($path, "r");
    $departments = array();
    if($fic !== false){
        while(($line = fgetcsv($fic, 1000, ",")) !== false){
            if($line[1] == $regionCode){
                $departments[] = [$line[0], $line[6]];
            }
        }
    }
    else{
        echo "Erreur : Ouverture impossible";
    }
    return $departments;
}

function getCities(string $departmentName): array
{
    $departmentName = urldecode($departmentName);
    $path = "csv/communes.csv";
    $file = fopen($path, "r");
    $villes = array();
    if($file !== false){
        while(($line = fgetcsv($file, 10000, ",")) !== false){
            if($line[13] == $departmentName){
                $villes[] = [$line[20], $line[2]];
            }
        }
    }
    else{
        echo "Erreur : Ouverture impossible";
    }
    fclose($file);
    return $villes;
}

function getInseeCode(?string $cityName) : ?string
{
    if($cityName === null){
        return null;
    }
    $path = "csv/communes.csv";
    $file = fopen($path, "r");
    if($file !== false){
        while(($line = fgetcsv($file, 1000, ",")) !== false){
            if(isset($line[2]) && $line[2] == $cityName){
                return $line[1];
            }
        }
    }
    return null;
}

function getVille_Cp(string $insee) : ?string
{
    $path = "csv/communes.csv";
    $file = fopen($path, "r");
    if($file !== false) {
        while (($line = fgetcsv($file, 1000, ",")) !== false) {
            if (isset($line[1]) && $line[1] == $insee) {
                return $line[2] . " " . $line[20];
            }
        }
    }
    return null;
}
