<?php
include "includes/functions.inc.php";
$title = "Tech";
include "includes/header.inc.php";
?>

<?php
$tabJson = getProcessedJSON();
$date = $tabJson["date"];
$explanation = $tabJson["explanation"];
$media_type = $tabJson["media_type"];
$titleJson = $tabJson["title"];
$url = $tabJson["url"];
?>
<h1>Bienvenue dans notre page développeur</h1>
<section>
    <h2>Image du jour de la NASA</h2>
    <p>Chaque jour la NASA publie une image/vidéo issue de notre univers, nous pouvons extraire
        son contenu en utilisant directement l'API fournit par la NASA.</p>
    <?php if ($media_type == "image"): ?>
        <figure>
            <img src="<?= htmlspecialchars($url) ?>" title="<?= $titleJson ?>"
                 alt="Image du jour issu de l'API de la NASA"/>
            <figcaption><em><?= $titleJson ?></em></figcaption>
        </figure>
    <?php else: ?>
        <video title="<?= $titleJson ?>">
            <source src="<?= htmlspecialchars($url) ?>">
        </video>
    <?php endif; ?>
    <div class="double-content-horizontal">
        <table class="normalTab">
            <thead>
            <tr>
                <th colspan="2">Informations complémentaires</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Titre</td>
                <td><?= $titleJson ?></td>
            </tr>
            <tr>
                <td>Date</td>
                <td><?= $date ?></td>
            </tr>
            <tr>
                <td>Type de média</td>
                <td><?= $media_type ?></td>
            </tr>
            <tr>
                <td>Contexte</td>
                <td><?= $explanation ?></td>
            </tr>
            </tbody>
        </table>
        <div class="double-content-vertical">
            <a href="https://en.wikipedia.org/wiki/NASA" target="_blank">
                <img src="images/logoNASA.png" alt="Logo de la NASA"/>
            </a>
            <p>La NASA (National Aeronautics and Space Administration) est l'agence spatiale américaine chargée
                de l'exploration de l'espace, de la recherche scientifique et du développement de technologies
                aérospatiales depuis 1958.</p>
        </div>
    </div>

</section>
<section>
    <h2>Géolocalisation avec adresse IP</h2>
    <div class="loc">
        <p>
            Dans cette partie, nous utiliserons l'API <b>Geoplugin</b> afin de localiser votre position.
        </p>
        <?php
        $tabXml = getPositionXML();
        $ip = $tabXml["geoplugin_request"];
        $country = $tabXml["geoplugin_countryName"];
        $region = $tabXml["geoplugin_region"];
        $latitude = $tabXml["geoplugin_latitude"];
        $longitude = $tabXml["geoplugin_longitude"];
        ?>
        <?php if ($tabXml && $tabXml["geoplugin_status"] == 200): ?>
            <table class="ipTab">
                <tbody>
                <tr>
                    <td>Adresse IP</td>
                    <td><?= $ip ?></td>
                </tr>
                <tr>
                    <td>Pays</td>
                    <td><?= $country ?></td>
                </tr>
                <tr>
                    <td>Region</td>
                    <td><?= $region ?></td>
                </tr>
                <tr>
                    <td>latitude</td>
                    <td><?= $latitude ?></td>
                </tr>
                <tr>
                    <td>longitude</td>
                    <td><?= $longitude ?></td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>
<?php
include "includes/footer.inc.php";
?>
