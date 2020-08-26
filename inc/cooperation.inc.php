<?php
require_once "pricelistXmlParser.inc.php";

if( $pdo == NULL )
    $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);
$get_content_query = "SELECT html_id, content FROM content
            WHERE module='cooperation.inc.php' ORDER BY html_id";
$content_obj = $pdo->query( $get_content_query );

$i = 0;
$j = 0;
foreach( $content_obj as $elem ){
    if( stristr( $elem['html_id'] , 'cooperationHeader' )  ){
        $cooperation_header[$i] = $elem['content'];
        $i++;
    }
    
    if( stristr( $elem['html_id'] , 'cooperationArticle' )  ){
        $cooperation_article[$j] = $elem['content'];
        $j++;
    }
    
    if( $elem['html_id'] == 'cooperationPageEmail' ){
        $cooperation_email = $elem['content'];
    }
    
    if( $elem['html_id'] == 'cooperationPagePhone' ){
        $cooperation_phone = $elem['content'];
    }
}

?>
<div id='cooperationPage'>
    <section>
        <h2 id='cooperationHeader1'><?=$cooperation_header[0]?></h2>
        <article id='cooperationArticle1'>
            <?=$cooperation_article[0]?>
        </article>
        <div id='cooperationPageInfo'>
            <strong id='cooperationPageEmail'><?=$cooperation_email?></strong>
            <strong id='cooperationPagePhone'><?=$cooperation_phone?></strong>
        </div>
        
        <div id='tableDiv'>
            <table border="1"  width='100%' height='100%'>
                <tr>
                    <th>Тип статуса</th>
                    <th>Цена</th>
                    <th></th>
                </tr>
                <? xml_parse( $cooperation_sax, file_get_contents('xml/pricelist.xml') ); ?>
            </table>
        </div>
    </section>
</div>