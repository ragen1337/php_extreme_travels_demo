<?php
    require_once "functions.inc.php";
?>
<div id="logo">
    <img src="../img/logo.png" alt="logo" height="110" width="110">
</div>  
<div id="exRates">
    <?
        echo $koeficient1a;
    ?>
</div>
<div id="headerInfo">
    <?
        require_once "headerInfo.inc.php";
    ?>
</div>
<div id="authorisationBar">
    <?
        authorisation_bar_switcher($authorisation_confirmed);
    ?>
</div>