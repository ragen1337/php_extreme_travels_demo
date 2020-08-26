<?php
require_once "inc/functions.inc.php";
require_once "inc/pageSwitcher.inc.php";
require_once "inc/authorisationCheckModule.inc.php";
require_once "inc/exRates.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div id='headerTop' style='background-image: url(img/headerImg.jpg)'>
            <? require_once "inc/headerTop.inc.php";?>
        </div>
        <div id="navigation">
           <? draw_menu( "top", $menuArray ); ?>
        </div>
    </header>
    <div id='page'>
        <? page_switcher( $page_now, $title_flag, $is_it_tour ); ?>
    </div>
    <footer>
        123
    </footer>
</body>
</html>