<?php
require_once "constants.inc.php";
require_once "functions.inc.php";

if( $pdo == null )
    $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);

$quoted_tour_id = $pdo->quote( (int)$_GET[tour] );

$query = "SELECT * FROM tours
            WHERE id=$quoted_tour_id";

$single_tour_info_obj = $pdo->query( $query );

$is_tour_exist_flag = 0;
foreach( $single_tour_info_obj as $elem ){
    $is_tour_exist_flag = 1;
    
    $tour_name = $elem[name];
    $tour_description = $elem[description];
    $tour_terms = $elem[terms];
    $tour_kind_of_sport = $elem[kindOfSport];
    $tour_free_places = $elem[freePlaces];
    $tour_date_from = $elem[dateFrom];
    $tour_date_to = $elem[dateTo];
    $tour_country = $elem[country];
    $tour_city = $elem[city];
    $tour_price = $elem[price];
    $tour_id = $elem[id];
    $tour_status = $elem[status];
}


$tour_photos_dir = 'img/tours/' . $tour_id ;
$tour_photos_list_array = scandir($tour_photos_dir);

$photo_collage_array = tour_page_photo_drawer( $tour_photos_list_array, $tour_id );
$photo_drawing_string = $photo_collage_array[0];
$photo_block_height = $photo_collage_array[1];


if( $is_tour_exist_flag && ($tour_status == 'active') ){
?>
<div id=tourPage style='height: <? echo (980 + $photo_block_height );?>px'>
    <div id='tourPageMainInfo'>
        <img src='../img/tours/<?=$tour_id?>/main.jpg' alt='photo' height='300' width='400' id='tourPageMainInfoImg'>
        <h1 id='tourPageMainInfoHeader'><?=$tour_name?></h1>
        <span id='tourPageMainInfoKindOfSport'>Вид спорта: <span><?=$tour_kind_of_sport?></span></span>
        <span id='tourPageMainInfoCountry'>Страна: <span><?=$tour_country?></span></span>
        <span id='tourPageMainInfoCity'>Город: <span><?=$tour_city?></span></span>
        <span id='tourPageMainInfoPrice'>Цена за человека: <span><?=$tour_price?>&#8381;</span></span>
        <span id='tourPageMainInfoDateFrom'>Начало тура: <span><?=$tour_date_from?></span></span>
        <span id='tourPageMainInfoDateTo'>Конец тура: <span><?=$tour_date_to?></span></span>
        <span id='tourPageMainInfoFreePlaces'>Осталось мест: <span><?=$tour_free_places?></span></span>
        <a href='#' id='tourPageMainInfoBuy'><span>Купить</span></a>
    </div>
    <div id='tourPageCommonInfo'>
        <section id='tourPageCommonInfoDescription'>
            <h2>Описание</h2>
            <article>
                <?=$tour_description?>
            </article>
        </section>
        <section id='tourPageCommonInfoTerms'>
            <h2>Условия</h2>
            <article>
                <?=$tour_terms?>
            </article>
        </section>
    </div>
    <section id='tourPagePhotosSection'>
        <h2>Фотографии</h2>
        <div id='tourPagePhotoCollageBlock' style='height: <?=$photo_block_height?>px'>
            <?=$photo_collage_array[0]?>
        </div>
    </section>
</div>
<?
}else{
    require_once "error404.inc.php";
}