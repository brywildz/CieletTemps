<?php
/**
 * @file meteo.php
 * Page de prévisions météo via carte interactive
 */

/**
 * Titre de la page actuelle, utilisé dans la balise <title>
 * @var $title
 */
$title = "Carte interactive";
/**
 * La métadonnée de description
 * @var $metaDesc
 */
$metaDesc ="Consultez la météo en France grâce à notre carte interactive intuitive, région par région, en temps réel.";
/**
 * La Métadonnée pour les mots clés
 * @var $metaKeywords
 */
$metaKeywords ="météo, carte interactive, prévisions, France, régions, géolocalisation, météo France";
/**
 * Feuille de style de la page
 * @var $css
 */
$css = "meteo.css";
include "includes/functions/functionsGlobal.php";
include "includes/functions/functionRanking.php";
if (isset($_GET["city"]) && $_GET["city"] != null) {
    setcookie("derniere_ville", $_GET["city"], time() + 60 * 60 * 24 * 7);
}
include "includes/pageParts/header.inc.php";
?>
<h1 class="meteo-h1">Prévisions météo interactive par région</h1>
<section class="meteoS">
    <h2>Carte des régions de France</h2>
    <?php if (isset($_COOKIE["derniere_ville"])): ?>
    <article class="derniere-ville" id="derniere_ville">

        <h2 class="default-h2">📍 Dernière ville consultée</h2>
            <p>Vous avez récemment consulté la météo de <strong><?= htmlspecialchars($_COOKIE["derniere_ville"]) ?></strong>.</p>
            <a class="href_derniere" href="meteo.php?city=<?= urlencode($_COOKIE["derniere_ville"]) ?>#weather" style="display:inline-block; margin-top:0.5rem; padding:0.5rem 1rem; background:#48aafb; color:white; border-radius:5px; text-decoration:none;">Voir à nouveau</a>
    </article>
    <?php endif; ?>


    <div class="map" id="map">
        <img src="images/meteo/<?= $styleName ?>/carte-dom.webp" usemap="#image-map" alt="Carte des départements d'Outre mer"/>

        <map name="image-map">
            <area target="_self" alt="Guadeloupe" title="Guadeloupe" href="meteo.php?region=Guadeloupe" coords="6,3,144,146" shape="rect"/>
            <area target="_self" alt="Martinique" title="Martinique" href="meteo.php?region=Martinique" coords="10,157,142,294" shape="rect"/>
            <area target="_self" alt="Guyane" title="Guyane" href="meteo.php?region=Guyane" coords="5,307,135,452" shape="rect"/>
            <area target="_self" alt="La Réunion" title="Réunion" href="meteo.php?region=La+Réunion" coords="8,463,148,601" shape="rect"/>
            <area target="_self" alt="Mayotte" title="Mayotte" href="meteo.php?region=Mayotte" coords="10,620,141,766" shape="rect"/>
        </map>

        <img src="images/meteo/carte-region.webp" usemap="#regionMap" alt="Carte des régions de France"/>
        <map name="regionMap">
            <area target="_self" alt="Île-de-France" title="Île-de-France"
                  href="meteo.php?region=Île-de-France#weather"
                  coords="364,226,373,221,383,221,391,220,400,220,407,221,414,226,419,231,433,231,440,233,448,231,452,244,457,252,461,262,461,271,457,279,447,282,438,290,430,294,422,298,413,294,411,281,402,283,398,274,392,285,387,273,377,267,371,258,373,247"
                  shape="poly"/>
            <area target="_self" alt="Grand Est " title="Grand Est " href="meteo.php?region=Grand%20Est#weather"
                  coords="463,281,465,273,463,265,464,256,470,251,474,244,475,236,472,229,478,226,478,217,481,210,488,208,494,208,498,203,496,196,496,188,501,185,503,178,509,173,514,169,520,164,526,159,535,150,534,156,536,162,539,166,539,172,542,177,547,180,554,181,557,186,562,190,565,194,569,198,574,200,582,199,589,199,595,199,606,203,618,206,623,210,627,214,629,219,634,221,640,222,646,225,653,226,659,226,668,229,675,230,681,231,688,232,695,233,701,234,707,237,707,236,707,237,711,245,707,248,703,253,698,258,693,262,692,267,693,273,693,279,689,284,687,290,685,298,686,304,683,309,686,314,683,319,681,326,681,332,680,338,683,344,678,348,674,354,667,356,661,349,657,340,653,333,647,328,641,328,633,321,626,318,619,314,613,314,607,315,601,314,593,317,588,323,581,325,578,330,579,336,571,335,567,339,561,341,554,342,545,338,548,330,540,326,534,316,526,313,519,313,513,316,506,316,500,311,493,312,486,310,480,302,472,297"
                  shape="poly"/>
            <area target="_self" alt="Hauts-de-France" title="Hauts-de-France"
                  href="meteo.php?region=Hauts-de-France#weather"
                  coords="374,143,370,151,377,153,381,159,384,164,386,171,389,176,385,185,388,189,389,195,388,201,387,206,383,214,389,212,396,212,403,212,409,214,414,218,418,221,422,223,428,221,432,223,440,224,445,221,450,225,451,230,453,234,457,241,460,245,464,249,468,238,469,230,471,223,473,214,474,204,479,204,487,203,493,203,493,195,494,185,498,179,500,172,504,166,498,159,498,149,502,145,500,137,477,133,484,135,489,134,473,124,465,121,460,112,456,104,438,107,431,101,426,92,424,85,422,79,415,81,408,81,400,85,393,87,387,91,380,93,379,100,379,105,381,112,379,117,379,123,378,129,377,134,382,139"
                  shape="poly"/>
            <area target="_self" alt="Normandie" title="Normandie" href="meteo.php?region=Normandie#weather"
                  coords="368,154,362,158,354,163,347,166,337,167,330,165,324,167,320,173,312,173,307,176,304,182,304,188,310,186,317,186,320,192,314,197,305,198,298,199,292,201,288,205,282,208,276,210,272,205,265,203,258,199,250,196,241,196,239,202,231,197,233,189,230,182,229,174,223,175,216,177,209,172,203,169,203,176,204,183,209,192,216,199,216,206,216,212,219,221,216,226,218,239,216,232,222,242,219,249,214,253,215,259,220,260,225,259,231,255,236,259,244,257,249,257,254,261,259,261,265,259,270,258,277,258,282,258,283,263,285,268,292,266,299,266,305,266,311,272,311,277,316,279,320,283,324,287,328,279,334,273,333,265,326,258,327,250,332,248,338,247,344,246,349,244,355,240,356,233,363,231,365,223,370,219,375,213,378,207,382,197,380,188,382,179,386,171,379,161,363,154"
                  shape="poly"/>
            <area target="_self" alt="Bretagne" title="Bretagne" href="meteo.php?region=Bretagne#weather"
                  coords="233,268,223,264,216,262,208,254,200,249,194,246,187,247,178,250,170,245,162,248,156,251,148,250,143,242,139,236,133,229,124,229,112,228,103,233,98,236,90,235,81,230,74,235,64,232,58,235,53,237,50,241,47,245,45,251,55,249,64,251,70,254,74,260,68,262,54,259,73,270,66,273,58,271,51,273,57,277,62,285,63,296,71,291,77,289,85,288,86,294,91,297,97,300,108,299,113,303,117,309,122,312,126,316,134,315,141,316,148,320,154,325,159,330,166,329,173,325,179,323,188,320,194,315,202,309,210,305,218,308,226,303,231,296,228,287,231,276,230,260"
                  shape="poly"/>
            <area target="_self" alt="Pays de la Loire" title="Pays de la Loire"
                  href="meteo.php?region=Pays%20de%20la%20Loire#weather"
                  coords="159,335,167,331,175,326,185,324,194,321,199,313,206,312,214,309,219,311,228,307,234,299,235,290,232,283,237,274,238,265,246,260,251,263,260,264,268,261,275,261,280,265,283,272,291,271,299,270,315,282,307,274,320,287,324,291,327,297,325,302,323,307,320,314,317,319,314,324,309,329,301,330,296,334,288,341,284,347,282,353,281,364,281,370,274,370,265,369,257,369,251,372,244,376,236,377,238,387,241,392,239,397,241,403,242,410,242,416,243,422,237,424,231,425,224,427,217,425,211,421,204,420,199,411,192,409,185,409,180,405,177,395,176,385,173,379,176,374,177,367,173,360,173,352,174,344,168,342,162,344,151,345"
                  shape="poly"/>
            <area target="_self" alt="Centre-Val de Loire" title="Centre-Val de Loire"
                  href="meteo.php?region=Centre-Val%20de%20Loire#weather"
                  coords="287,360,287,368,289,345,286,353,295,342,300,337,307,333,318,328,321,321,324,313,327,306,330,300,328,291,328,281,334,276,337,270,336,263,331,256,336,250,343,248,350,247,355,242,361,237,365,240,367,247,367,252,368,258,371,263,376,269,380,274,383,278,384,283,388,286,394,288,401,286,407,287,410,294,413,301,420,299,425,303,431,298,438,298,441,304,442,310,441,316,437,320,432,328,435,335,436,341,430,346,433,353,437,357,440,363,443,369,444,376,444,383,445,389,444,396,444,401,438,404,430,406,418,406,415,414,411,419,405,425,397,427,389,425,382,425,374,424,367,426,358,429,349,426,338,424,331,417,328,406,322,396,316,391,316,381,310,379,302,382,294,376"
                  shape="poly"/>
            <area target="_self" alt="Auvergne-Rhône-Alpes" title="Auvergne-Rhône-Alpes"
                  href="meteo.php?region=Auvergne-Rhône-Alpes#weather"
                  coords="402,435,404,429,412,425,416,421,420,415,424,410,432,406,442,408,451,405,456,408,460,414,468,415,473,408,478,411,483,419,489,424,493,428,493,437,494,443,501,448,510,449,519,444,529,443,537,447,542,437,548,426,544,431,556,426,562,431,569,436,572,441,579,437,584,440,592,438,600,435,604,440,600,446,595,458,601,456,609,454,616,451,618,443,624,441,629,438,637,438,640,444,640,450,640,456,648,462,652,469,651,477,643,483,646,490,653,499,656,508,657,517,649,521,643,527,632,534,625,533,615,531,616,537,616,545,611,549,608,554,602,556,592,563,586,567,580,570,577,576,571,582,573,589,577,594,580,600,581,607,577,611,571,608,560,599,566,601,554,597,545,594,546,584,539,583,533,588,525,589,523,595,517,588,508,588,501,590,495,592,493,581,491,571,483,570,481,559,475,556,469,548,459,550,452,543,449,548,440,545,439,553,436,560,423,542,414,550,409,555,399,566,392,559,386,555,384,546,384,538,386,526,391,519,398,514,406,510,410,500,409,491,410,482,407,475,412,468,416,460,414,451,410,442"
                  shape="poly"/>
            <area target="_self" alt="Nouvelle-Aquitaine" title="Nouvelle-Aquitaine"
                  href="meteo.php?region=Nouvelle-Aquitaine#weather"
                  coords="240,688,233,687,225,689,220,679,213,677,205,676,198,669,191,665,180,665,180,654,175,646,165,640,173,636,179,629,183,620,186,611,190,603,193,594,195,584,197,575,197,562,202,553,209,553,214,546,207,541,203,531,205,521,209,511,209,501,211,488,216,488,220,494,223,501,227,508,231,514,234,518,238,522,238,512,234,504,234,494,231,487,227,481,219,475,213,466,218,462,220,453,223,444,220,437,220,427,228,428,236,425,244,424,248,415,247,405,246,394,245,384,242,379,249,376,254,372,264,369,270,370,278,370,284,370,291,372,295,378,299,382,306,383,314,386,315,394,326,407,321,399,330,412,333,415,337,421,339,426,346,427,351,429,359,430,364,431,375,427,381,428,388,427,396,428,401,432,402,441,407,444,411,449,412,456,412,462,406,470,406,476,408,481,408,488,408,494,409,508,382,534,386,523,377,538,370,534,362,531,354,528,346,533,344,538,342,545,338,551,331,556,323,560,321,567,321,573,315,576,314,583,315,590,310,595,302,602,292,603,282,602,276,604,268,605,258,604,253,609,252,617,246,622,245,629,257,637,250,632,255,645,253,651,251,663,247,669,241,673,242,679"
                  shape="poly"/>
            <area target="_self" alt="Occitanie" title="Occitanie" href="meteo.php?region=Occitanie#weather"
                  coords="247,695,262,697,275,702,244,686,246,677,251,667,257,657,260,644,257,633,250,628,257,619,260,610,267,612,274,606,280,608,288,608,296,606,304,608,310,603,317,599,318,590,324,583,325,575,327,567,332,562,338,559,344,550,347,541,358,537,366,539,375,539,378,547,381,555,381,562,389,562,393,569,401,569,408,562,414,556,422,549,426,555,428,560,433,564,440,559,444,553,451,549,457,553,465,554,476,561,481,567,484,571,484,577,488,584,490,591,491,598,497,597,506,597,513,599,522,602,526,606,529,616,526,629,520,636,517,642,509,646,506,654,496,659,488,660,481,661,472,663,463,668,447,676,436,679,429,685,429,692,428,698,428,705,428,712,430,718,435,724,439,733,439,739,429,735,420,737,413,739,403,738,394,735,384,731,378,734,370,737,366,728,357,725,353,713,339,710,330,704,317,700,304,696,295,696,283,700"
                  shape="poly"/>
            <area target="_self" alt="Provence-Alpes-Côte d'Azur" title="Provence-Alpes-Côte d'Azur"
                  href="meteo.php?region=Provence-Alpes-Côte%20d'Azur#weather"
                  coords="506,661,515,653,515,644,523,641,525,632,532,628,534,619,532,610,529,602,527,594,538,593,541,587,554,601,560,602,566,608,571,613,578,614,582,608,581,599,578,592,578,584,581,572,588,570,595,563,602,558,613,554,617,549,616,540,621,534,633,538,636,544,641,550,648,556,655,561,655,570,650,575,650,582,650,588,653,593,657,599,663,605,672,610,679,610,683,616,691,624,684,629,682,635,683,641,676,644,668,649,663,654,663,660,654,657,650,664,641,664,637,671,630,676,635,681,628,683,619,688,605,689,593,685,587,690,570,682,561,682,554,676,546,672,533,670,525,670"
                  shape="poly"/>
            <area target="_self" alt="Corse" title="Corse" href="meteo.php?region=Corse#weather"
                  coords="711,633,705,639,704,652,698,661,692,656,688,664,678,665,672,673,668,684,669,692,671,700,674,709,675,715,675,722,683,733,683,743,689,744,695,747,697,755,703,746,704,733,707,725,709,716,712,708,715,700,712,688,712,679,712,671,711,661,712,651,712,642"
                  shape="poly"/>
            <area target="_self" alt="Bourgogne-Franche-Comté" title="Bourgogne-Franche-Comté"
                  href="meteo.php?region=Bourgogne-Franche-Comté#weather"
                  coords="619,409,619,403,625,398,631,391,640,389,647,383,650,375,650,363,655,356,658,347,652,340,646,333,637,330,629,323,622,320,613,319,603,319,596,319,592,325,587,328,585,334,582,339,574,339,569,342,558,344,548,339,543,329,535,322,525,314,520,319,512,319,503,316,494,316,486,311,479,304,472,298,467,289,462,285,452,284,445,285,443,292,444,299,446,306,447,312,444,317,440,321,437,327,438,334,440,340,436,348,440,354,443,359,448,366,449,372,449,378,451,385,450,392,452,399,454,405,462,407,465,412,473,407,480,410,486,415,491,419,493,424,495,430,497,438,500,444,507,445,514,442,519,442,528,440,535,441,539,435,543,426,552,423,559,423,564,426,566,431,571,436,579,432,586,434,591,435,598,433,604,426,607,419,614,414"
                  shape="poly"/>
        </map>
    </div>
</section>


<?php
if (isset($_GET["region"]) && $_GET["region"] != null) {
    $region = $_GET["region"];
}
/**
 * Formulaire de la ville ou du département selon les paramètre de l'URL
 * @var $form
 */
$form = traitementGET();
/**
 * Tableau des informations météos de l'instant, des prévisions de la journée et des prochains jours
 * @var $weatherAndForecast
 */
$weatherAndForecast = traitementMeteo();
/**
 * Tableau des informations de l'instant
 * @var $weatherTab
 */
$weatherTab = $weatherAndForecast[0];
/**
 * Tableau des prévisions météo des prochains jours
 * @var $forecastTab
 */
$forecastTab = $weatherAndForecast[1];
/**
 * Tableau des prévisions météo de la journée
 * @var $dayWeatherTab
 */
$dayWeatherTab = $weatherAndForecast[2];
if($weatherTab["cond"]){
    $h2 = "Météo actuelle";
}
else{
    $h2 = "Choix du lieu";
}
?>


<?php if (($form != null) || isset($_GET['city'])):?>
<section class="meteoS" id="weather">
    <h2><?=$h2?></h2>
    <?php if ($weatherTab["cond"] !== true && $weatherTab["cond"] == "introuvable"):?>
        <p style="font-size: 30px; color: red; text-align: center">Notre système ne permet par l'affichage des données météorologiques hors France</p>
    <?php else:?>
    <div id="selection" class='selection'>
         <?php echo $form; ?>
    </div>
    <?php if ($weatherTab["cond"] && $forecastTab["cond"]):?>
        <?php refreshCsv($weatherTab["city"])?>
        <div class="meteo">
            <h3 style="text-align: left"><b>Météo <?= $_GET["city"] ?> : <?=ucfirst($weatherTab["desc"])?></b></h3>
            <div class="meteo-in">

                <div class="meteo-info-degre">

                    <div style="display: flex">
                        <img style=
                             "flex-shrink: 0; flex-grow: 0; height: auto; width: auto;"
                             src="https://openweathermap.org/img/wn/<?= $weatherTab["img"] ?>@2x.png"
                              alt="Illustration météo"/>
                        <p style="font-size: 40px"><?= $weatherTab["deg"] ?>°C</p>
                    </div>
                    <p style="font-size: 20px">🎯 Ressenti <?=$weatherTab["feel"]?> </p>
                    <p>❄️ Min : <?= $weatherTab["min"]?>°C</p>
                        <p>🔥 Max : <?= $weatherTab["max"]?>°C</p>
                </div>
                <img src="images/meteo/separation-line.webp" alt="trait"/>
                <div class="meteo-info">
                    <p style="font-size: 25px">💨 Vent : <?=$weatherTab["wind"]?> m/s</p>
                    <p style="font-size: 25px">☁️ Nuages : <?= $weatherTab["clouds"] ?>%</p>
                    <p style="font-size: 25px">💧 Humidité : <?= $weatherTab["humidity"] ?>%</p>
                </div>
            </div>
            <div class="forecast-ask">
                <h4>Voir les prévisions ?</h4>
                <form  action="meteo.php?city=<?= $_GET['city'] ?>#forecast" method="get">
                    <label>
                        Sélectionner une date :
                        <select name="day">
                            <option value="0"><?= $forecastTab[0]["date"] ?> &#9660;</option>
                            <option value="1"><?= $forecastTab[1]["date"] ?> </option>
                            <option value="2"><?= $forecastTab[2]["date"] ?> </option>
                            <option value="3"><?= $forecastTab[3]["date"] ?> </option>
                            <option value="all">4 prochains jours</option>
                        </select>
                    </label>
                    <input type="hidden" name="city" value="<?= $_GET['city'] ?>"/>
                    <button type="submit">Valider</button>
                </form>
            </div>
        </div>

        <?php echo printWeatherDay($dayWeatherTab) ?>
    <?php endif; ?>
</section>
<?php endif;?>
<?php endif;?>

<?php if(isset($_GET['day'])){
    $day = $_GET['day'];
    if($day == "all"){
        echo printForecastAll($forecastTab);
    }
    else{
        echo printForecast($forecastTab, $day);
    }
}?>


<?php include "includes/pageParts/footer.inc.php"; ?>
