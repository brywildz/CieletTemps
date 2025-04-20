<?php

declare(strict_types=1);

/**
 * Lie le fichier csv des régions de France et renvoie le nom et le code de la région sous forme de tableau
 * @param string $regionName nom de la région
 * @return array|void en fonction du résultat de la lecture de la fonction fgetcsv
 */
function getRegion(string $regionName){
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

/**
 * Lie le fichier csv des départements de France et renvoie le nom et le code d'un département sous forme de tableau
 * @param string $regionCode le code de regions du département recherché
 * @return array en fonction du résultat de la lecture de la fonction fgetcsv
 */
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

/**
 * Lie le fichier csv des communes de France et renvoie le nom et le code postale d'une ville.
 * @param string $departmentName nom du département
 * @return array en fonction du résultat de la lecture de la fonction fgetcsv
 */
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

/**
 * Lie le fichier csv des communes de France et renvoie le code INSEE d'une ville.
 * @param ?string $cityName nom de la ville
 * @return ?string en fonction du résultat de la lecture de la fonction fgetcsv
 */
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

/**
 * Lie le fichier csv des communes de France et renvoie le nom et le code postale d'une ville
 * @param string $insee code insee de la ville
 * @return string|null en fonction de la réussite de la recherche
 */
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
