<?php
$title = "Statistiques";
$metaDesc ="Accédez aux statistiques météo détaillées : températures, précipitations, tendances climatiques régionales et nationales.";
$metaKeywords ="statistiques météo, températures, précipitations, tendances climatiques, analyse, météo France";
$css = "stats.css";
include "includes/functions/functionStats.php";
include "includes/functions/functionRanking.php";
include "includes/pageParts/header.inc.php";
?>

    <h1 class="default-h1">Informations statistiques</h1>

    <section class="default-section" id="stats">
        <h2 class="default-h2">Les villes les plus consultées de notre site</h2>
        <p>Pour simplifier la lecture, la valeur maximale est projetée sur une échelle arrondie supérieure (ex. 1000 au lieu de 936),
            utilisée comme référence pour le calcul des proportions graphiques.</p>
        <?php
        $tabRanking = getRankingCitiesCsv();
        echo showRanking($tabRanking);
        ?>
    </section>


<?php
include "includes/pageParts/footer.inc.php";
?>
