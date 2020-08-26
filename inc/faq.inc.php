<?php
require_once "faqXmlParser.inc.php";
?>
<div id='faqPage'>
    <section>
        <h2>Часто задаваемые вопросы:</h2>
        <div id='questionsBlock'>
            <? xml_parse( $faq_sax, file_get_contents('xml/faq.xml') ); ?>
        </div>
    </section>
</div>