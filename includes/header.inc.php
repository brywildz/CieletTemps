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

       $style = ($styleName ?? 'clair') === "sombre" ? "style/style_sombre.css" : "style/style.css";
       ?>

        <link rel="stylesheet" href="<?= $style ?>"/>
        <title><?= $title ?></title>
        <link rel="icon" href="images/favicon.png" type="image/png"/>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><img src="images/grand.png" alt="icone du site"/></a>
        </div>
        <nav>
            <ul>
                <li><a href="meteo.php">Prévisions</a></li>
            </ul>
        </nav>


        <div class="style-toggle">
            <?php if (!isset($_COOKIE["style"]) || $_COOKIE["style"] == "clair" || (isset($_GET["style"]) && $_GET["style"] == "clair")): ?>
                <a href="?style=sombre" title="Activer le mode sombre">
                    <img src="images/mode.png" alt="mode sombre" height="30">
                </a>
            <?php else: ?>
                <a href="?style=clair" title="Activer le mode clair">
                    <img src="images/mode.png" alt="mode clair" height="30">
                </a>
            <?php endif; ?>
        </div>
    </header>
    <main>
