<!DOCTYPE html>
<html lang="fr">
    <head>
       <?php
       if (isset($_GET["style"])) {
           $styleName = $_GET["style"];
           setcookie("style", $styleName, time() + 60 * 60 * 24 * 10);
           $url = strtok($_SERVER["REQUEST_URI"], '?');
           header("Location: $url");
           exit;
       } elseif (isset($_COOKIE["style"])) {
           $styleName = $_COOKIE["style"];
       }

       $style = ($styleName ?? 'clair') === "sombre" ? "style/dark/" : "style/light/";
       ?>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?= $style ?>global.css"/>
        <link rel="stylesheet" href="<?= $style.$css ?>"/>
        <?php if(isset($css2)) :?>
            <link rel="stylesheet" href="<?= $style.$css2 ?>"/>
        <?php endif; ?>
        <title><?= $title ?></title>
        <link rel="icon" type="image/png" href="images/header/favicon.png" />
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><img src="images/header/logo-nav.png" alt="icone du site"/></a>
        </div>
        <nav>
            <ul>
                <li class="menu-deroulant">
                    <a href="meteo.php">Explorer ▾</a>
                    <div class="choice-list">
                            <a href="search.php">
                            <img src="images/header/search-text.png" alt="icone de carte"/>
                        </a>
                            <a href="meteo.php">
                                <img src="images/header/search-map.png" alt="icone de carte"/>
                            </a>
                    </div>
                </li>
                <lI><a class="select-nav" href="stats.php">Statistiques</a></lI>
                <li><a class="select-nav" href="">À propos</a></li>
            </ul>
        </nav>
        <div class="style-toggle">
            <?php if (!isset($_COOKIE["style"]) || $_COOKIE["style"] == "clair" || (isset($_GET["style"]) && $_GET["style"] == "clair")): ?>
            <a href="?style=sombre" class="dark-mode">🌙 Mode nuit</a>
            <?php else: ?>
            <a href="?style=clair" class="light-mode">☀️ Mode jour</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
