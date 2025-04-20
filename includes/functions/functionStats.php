<?php
declare(strict_types=1);

/**
 * Retourne une chaine de caractère de l'histogramme des villes les plus consulté sur notre site
 * @param array|null $rankingTab le classement sous forme de tableau
 * @return string
 */
function showRanking(?array $rankingTab) : string
{
    $rankingTab = array_slice($rankingTab, 0, 5, true);
    $s = "<div class='graph'>";
    if(empty($rankingTab)){
        $s .= "<p style='text-align: center'>Aucune ville n'a été consulté pour le moment</p>";
        return $s;
    }
    $tabMax = str_split(reset($rankingTab));
    $length = sizeof($tabMax);
    $maxTab = ["1"];
    for($i = 0; $i < $length; $i++){
        $maxTab[] = "0";
    }
    $max = (int)implode("", $maxTab);
    $maxPrinted = number_format($max, 0, '', ' ');
    $i = 100;
    $bleu = 25 + $i;
    foreach ($rankingTab as $ville => $valeur){
        $s.= "<div><p>$ville : $valeur</p>";
        $s.= "<div style='background:rgb(39,39,$bleu,100);height:20px;width:" .((($valeur/$max)*100)*10)."px;'></div></div>";
        $bleu = $bleu + $i;
    }
    $s .= "<p class='graphLegend'><em>Echelle arrondie superieur : $maxPrinted </em></p>";
    $s.="</div>";
    return $s;
}
