<?php
$faq_sax = xml_parser_create('utf-8');

function onStart( $parser, $tag, $attributes = null ){
    if( $tag == 'QUESTIONS' )
        echo "<ul>";
    
    if( $tag == 'QUESTION' )
        echo "<li>";
    
    if( $tag == 'ASK' )
        echo "<span class='faqAsk'>";
    
    if( $tag == 'ANSWER' )
        echo "<STRONG class='faqAnswer'>";
}

function onEnd( $parser, $tag ){
    if( $tag == 'QUESTIONS' )
        echo "</ul>";
    
    if( $tag == 'QUESTION' )
        echo "</li>";
    
    if( $tag == 'ASK' )
        echo "</span>";
    
    if( $tag == 'ANSWER' )
        echo "</STRONG>";
}

function onText( $parser, $text ){
    echo $text;
}

xml_set_element_handler($faq_sax, "onStart", "onEnd");
xml_set_character_data_handler($faq_sax, "onText");