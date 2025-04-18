<?php
$title = "Tech";
$css = "tech.css";
include "includes/functions/functionsTech.php";
include "includes/pageParts/header.inc.php";
?>

<?php
$tabJson = getProcessedJSON();
$date = $tabJson["date"];
$explanation = $tabJson["explanation"];
$media_type = $tabJson["media_type"];
$titleJson = $tabJson["title"];
$url = $tabJson["url"];
?>
<h1 class="default-h1">Bienvenue dans notre page développeur</h1>
<section class="default-section" id="image">
    <h2 class="default-h2">Image du jour de la NASA</h2>
    <p>Chaque jour la NASA publie une image/vidéo issue de notre univers, nous pouvons extraire
        son contenu en utilisant directement l'API fournit par la NASA.</p>
    <?php if ($media_type == "image"): ?>
        <figure>
            <img src="<?= htmlspecialchars($url) ?>" title="<?= $titleJson ?>"
                 alt="Image du jour issu de l'API de la NASA"/>
            <figcaption><em><?= $titleJson ?></em></figcaption>
        </figure>
    <?php else: ?>
        <iframe
            width="560"
            height="315"
            src="<?= htmlspecialchars($url) ?>"
            title="<?= htmlspecialchars($titleJson) ?>"
            allowfullscreen>
        </iframe>
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
                <img src="images/tech/logoNASA.png" alt="Logo de la NASA"/>
            </a>
            <p>La NASA (National Aeronautics and Space Administration) est l'agence spatiale américaine chargée
                de l'exploration de l'espace, de la recherche scientifique et du développement de technologies
                aérospatiales depuis 1958.</p>
        </div>
    </div>

</section>
<section class="default-section" id="ip">
    <h2 class="default-h2">Géolocalisation avec adresse IP</h2>
    <article>
        <h3>Format PHP</h3>
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
    </article>

    <article>
        <h3>Format JSON</h3>
        <div class="loc">
            <p>
                Dans cette partie, nous utiliserons l'API <b>ipinfo</b> afin de localiser votre position.
            </p>
            <?php
            $geoJson = getPositionJSON();
            $ip = $geoJson["ip"];
            $country = $geoJson["country"];
            $region = $geoJson["region"];
            $latitude = $geoJson["loc"];
            $postal = $geoJson["postal"];
            ?>
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
                        <td>Coordonnée GPS</td>
                        <td><?= $latitude ?></td>
                    </tr>
                    <tr>
                        <td>Code postal</td>
                        <td><?= $postal ?></td>
                    </tr>
                    </tbody>
                </table>
        </div>
    </article>
    <article>
        <h3>Format XML</h3>
        <div class="loc">
            <p>
                Dans cette partie, nous utiliserons l'API <b>WhatisMyIP</b> afin de localiser votre position.
            </p>
            <?php
            $geoXML2 = getPositionXML2();
            $ip = $geoXML2->server_data->ip;
            $country = $geoXML2->server_data->country;
            $region = $geoXML2->server_data->region;
            $latitude = $geoXML2->server_data->latitude;
            $longitude = $geoXML2->server_data->longitude;
            ?>
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
                    <td>Latitude</td>
                    <td><?= $latitude ?></td>
                </tr>
                <tr>
                    <td>Longitude</td>
                    <td><?= $longitude ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </article>
</section>
<?php
include "includes/pageParts/footer.inc.php";
?>
