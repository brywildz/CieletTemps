<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php
        if(isset($_GET["style"]) && $_GET["style"]=="sombre"){
            $style="style/style_sombre.css";
        }
        else{
            $style="style/style.css";
        }
        ?>
        <link rel="stylesheet" href="<?=$style?>"/>
        <title><?= $title ?></title>
        <link rel="icon" href="images/favicon.png" type="image/png"/>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><img src="images/grand.png"/></a>
        </div>
        <nav>
            <ul>
                <li><a href=meteo.php>Prévisions</a></li>
            </ul>
        </nav>

    </header>
    <main>