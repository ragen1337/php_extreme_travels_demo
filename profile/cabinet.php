<?php
require_once "profileVisitorIdentification.inc.php";

header("Cache-Control: no-cache, no-store, max-age=0");

if( $access != "AGENCY" && $access != "ADMIN" ){
    $content = "<img src='../img/oops.jpg' alt='У вас нед доступа к этой странице' id='oopsImg'>";
    $editContentHeader = "У вас нет доступа к этой странице!";
    $allBlocksHeight = "497px";
}else{
    require_once "whatToChangeSwitcher.inc.php";
    if( isset( $_GET['editTour'] ) ){
        require_once "changeTourPageDrawer.inc.php";
    }
    if( $access == 'ADMIN' && isset( $_GET['editPage'] ) ){
        require_once "editPageDrawer.inc.php";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редактор</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <section id='editorCabinet' style='height:<?=$allBlocksHeight;?>'>
        <h1><?=$editContentHeader?></h1>
        <?=$content;?>
        <?=$bottomBar;?>
    </section>
</body>
</html>