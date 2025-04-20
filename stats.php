<?php
$title = "Statistiques";
$metaDesc ="Accédez aux statistiques météo détaillées : températures, précipitations, tendances climatiques régionales et nationales.";
$metaKeywords ="statistiques météo, températures, précipitations, tendances climatiques, analyse, météo France";
$css = "stats.css";
include "includes/functions/functionStats.php";
include "includes/functions/functionsGlobal.php";
include "includes/functions/functionRanking.php";
include "includes/pageParts/header.inc.php";
?>

    <h1>Informations statistiques</h1>

    <section class="default-section" id="stats" style=
    "<?php if($styleName == "light") :?>background-color:white; <?php else:?> background-color:#1F1F1F; <?php endif;?> border-radius:5px;">
        <h2>Les villes les plus consultées de notre site</h2>
        <p>Pour simplifier la lecture, la valeur maximale est projetée sur une échelle arrondie supérieure (ex. 1000 au lieu de 936),
            utilisée comme référence pour le calcul des proportions graphiques.</p>
        <?php
        $tabRanking = getRankingCitiesCsv();
        echo showRanking($tabRanking);
        ?>

        <h2>Nombre de visiteurs de notre site</h2>
        <p>Pour cette statistique, nous nous basons sur le nombre de rafraichissements de la page d'accueil de notre site par un nouvel utilisateur.</p>
        <p style="margin-top: 50px; text-align: center; font-size: 60px"><?php echo hitAndRefresh(false)?></p>
    </section>


<?php
include "includes/pageParts/footer.inc.php";
?>
