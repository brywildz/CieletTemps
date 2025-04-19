<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="<?= $metaDesc ?>"/>
        <meta name="keywords" content=" <?= $metaKeywords ?>"/>
        <meta name="author" content="Dylan Manseri, Amadou Bawol — Projet L2 Informatique, CY Cergy Paris Université"/>
        <meta name="publisher" content="CY Cergy Paris Université - Département Informatique"/>
        <meta name="copyright" content="© 2025 Dylan Manseri et Amadou Bawol. Tous droits réservés."/>

        <?php
        $styleName = 'light';
        if (!isset($_GET['style'])) {
            $params = $_GET;
            if(isset($_COOKIE['style'])){
                $params['style'] = $_COOKIE['style'];
            }
            else{
                $params['style'] = "light";
            }

            $url = strtok($_SERVER['REQUEST_URI'], '?');
            $query = http_build_query($params);

            header("Location: $url?$query");
            exit;
        }
        if (isset($_GET["style"])) {
            $styleName = $_GET["style"];
            setcookie("style", $styleName, time() + 60 * 60 * 24 * 10);
        }
         else{
             if(isset($_COOKIE["style"])){
                 $styleName = $_COOKIE["style"];
             }
         }
        $style = ($styleName ?? 'light') === "dark" ? "style/dark/" : "style/light/";
        ?>
        <link href="https://fonts.googleapis.com/css2?family=Inter&amp;display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="<?= $style ?>global.css"/>
        <link rel="stylesheet" href="<?= $style.$css ?>"/>
        <?php if(isset($css2)) :?>
            <link rel="stylesheet" href="<?= $style.$css2 ?>"/>
        <?php endif; ?>
        <link rel="stylesheet" href="style/light/footer.css"/>
        <title><?= $title ?></title>
        <link rel="icon" type="image/png" href="images/header/favicon.png" />
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php?style=<?=$_GET["style"]?>">
                <img src="images/header/logo-nav.png" alt="icone du site"/>
            </a>
        </div>
        <nav>
            <ul>
                <li class="menu-deroulant">
                    <a href="search.php?style=<?=$_GET["style"]?>">Explorer ▾</a>
                    <div class="choice-list">
                            <a href="search.php?style=<?=$_GET["style"]?>">
                            <img src="images/header/search-text.png" alt="icone de carte"/>
                        </a>
                            <a href="meteo.php?style=<?=$_GET["style"]?>">
                                <img src="images/header/search-map.png" alt="icone de carte"/>
                            </a>
                    </div>
                </li>
                <li><a class="select-nav" href="stats.php?style=<?=$_GET["style"]?>">Statistiques</a></li>
                <li><a class="select-nav" href="about.php?style=<?=$_GET["style"]?>">À propos</a></li>
            </ul>
        </nav>
        <div class="style-toggle">
            <a class="select-nav-cookie" href="cookies.php">Cookies</a>
            <?php if (!isset($_GET["style"]) || $_GET["style"] == "light"): ?>
            <a href="?style=dark" class="dark-mode">🌙 Mode nuit</a>
            <?php else: ?>
            <a href="?style=light" class="light-mode">☀️ Mode jour</a>
            <?php endif; ?>
        </div>
    </header>
    <main>