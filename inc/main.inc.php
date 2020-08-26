<?php
require_once "constants.inc.php";
require_once "functions.inc.php";

if( $pdo == null )
    $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);
$query = "SELECT * from content
            WHERE module = 'main.inc.php'";
$result = $pdo->query($query);

$i = 0;
$j = 0;
$k = 0;
$a = 0;
foreach( $result as $elem ){
    if( $elem[html_class] == 'tourTypesHeader' ){
        $tour_type_headers_array[$i] = $elem[content];
        $tour_type_headers_hrefs_array[$i] = $elem[href];
        $i++;
    }
    if( $elem[html_class] == 'tourTypesDescription' ){
        $tour_type_descriptions_array[$j] = $elem[content];
        $j++;
    }
    if( $elem[html_id] == 'mainAdvertisingHref' ){
        $mainAdvertisingHref = $elem[href];
    }
    if( $elem[html_id] == 'mainPageBottomBarHeader' ){
        $mainPageBottomBarHeader = $elem[content];
    }
    if( $elem[html_class] == 'mainPageBottomBarElemHref' ){
        $main_page_bottom_bar_elem_hrefs[$k] = $elem[href];
        $k++;
    }
    if( $elem[html_class] == 'mainPageBottomBarElemHeader' ){
        $main_page_bottom_bar_elem_headers[$a] = $elem[content];
        $a++;
    }
}
?>

<div id="main">
    <div id="mainForSectionsBlock">
        <?tour_types_drawing( $tour_type_headers_array, $tour_type_descriptions_array, $tour_type_headers_hrefs_array );?>
    </div>
    <aside id="mainForAdvertise">
        <a href="<?=$mainAdvertisingHref?>" id="mainAdvertisingHref"><img src='../img/mainAdvertising.jpg' alt='РЕКЛАМА' id='mainAdvertising' width='200' height='900'></a>
    </aside>
    <section id="mainPageBottomBar">
        <h1 id="mainPageBottomBarHeader"><?=$mainPageBottomBarHeader?></h1>
        <?main_page_bottom_bar_drawing( $main_page_bottom_bar_elem_hrefs, $main_page_bottom_bar_elem_headers );?>
    </section>
    <script src="../js/main.inc.script.js"></script>
</div>