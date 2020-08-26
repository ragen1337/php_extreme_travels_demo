<?php
    require_once "profileContentDrawing.inc.php";
    require_once "profileEditDataFilter.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Мой профиль</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div id='profilePage'>
        <?
        echo $welcome;
        echo $content;
        ?>
        <div id=profileBottomBar>
            <? 
            echo $back;
            echo $cabinetPanel;
            ?>
        </div>
    </div>
</body>
</html>