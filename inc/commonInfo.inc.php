<?php
if( $pdo == NULL )
    $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);
$get_content_query = "SELECT html_id, content FROM content
            WHERE module='commonInfo.inc.php' ORDER BY html_id";
$content_obj = $pdo->query( $get_content_query );

$i = 0;
$j = 0;
foreach( $content_obj as $elem ){
    if( stristr( $elem['html_id'] , 'commonInfoHeader' )  ){
        $commonInfoHeader[$i] = $elem['content'];
        $i++;
    }
    
    if( stristr( $elem['html_id'] , 'commonInfoArticle' )  ){
        $commonInfoArticle[$j] = $elem['content'];
        $j++;
    }
}

?>
<div id='commonInfoPage'>
    <section>
        <h2 id='commonInfoHeader1'><?=$commonInfoHeader[0];?></h2>
        <article id='commonInfoArticle1'>
            <?=$commonInfoArticle[0];?>
        </article>
    </section>
    <section>
        <h2 id='commonInfoHeader2'><?=$commonInfoHeader[1];?></h2>
        <article id='commonInfoArticle2'>
            <?=$commonInfoArticle[1];?>
        </article>
    </section>
</div>