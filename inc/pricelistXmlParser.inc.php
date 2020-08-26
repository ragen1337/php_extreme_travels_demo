<?php
$cooperation_sax = xml_parser_create('utf-8');

function onStart( $parser, $tag, $attributes = null ){
    if( ($tag != "PRICELIST") && ($tag != "STATUS") && ( $tag != "ID" ) ){
        echo "<td height='40'>";
    }
    if( $tag == "STATUS" )
        echo "<tr>";
    if( $tag == "ID" )
        echo "<td height='40'><a href='?buyStatus=";
}

function onEnd( $parser, $tag ){
    if( ($tag != "PRICELIST") && ($tag != "STATUS") && ( $tag != "ID" ) ){
        echo "</td>";
    }
    if( $tag == "STATUS" )
        echo "</tr>";
    if( $tag == "ID" )
        echo "'>КУПИТЬ</a></td>";
}

function onText( $parser, $text ){
    echo $text;
}

xml_set_element_handler($cooperation_sax, "onStart", "onEnd");
xml_set_character_data_handler($cooperation_sax, "onText");