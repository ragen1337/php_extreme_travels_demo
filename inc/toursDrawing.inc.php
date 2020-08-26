<?php
$i = 0;


foreach( $tours_all_info as $single_tour ){
    $flag = $i % 2;
    if( $flag ){
        $float_image = 'right';
        $float_block_content = 'left';
        $img_style='border-top-left-radius: 10%;border-top-right-radius: 10%';
    }else{
        $float_image = 'left';
        $float_block_content = 'right';
        $img_style='border-top-left-radius: 10%';
    }
    
    echo "
    <div class='tourBlock'>
        <div class='tourBlockContent'>
            <section class='tourBlockInfo' style='float:$float_block_content'>
                <h2 class='tourBlockHeader'>{$single_tour[name]}</h2>
                <span class='tourDateInfoSpan'> (С {$single_tour[dateFrom]} ПО {$single_tour[dateTo]})</span>
                <div class='tourBlockMainInfo'>
                    <div class='tourSubInformationTop'>
                        <span class='tourKindOfSportSpan'>{$single_tour[kindOfSport]}</span>
                        <span class='tourCitySpan'>{$single_tour[city]}</span>
                        <span class='tourCountrySpan'>{$single_tour[country]}</span>
                    </div>
                    <div class='tourDescription'>
                        {$single_tour[description]}
                    </div>
                    <div class='tourSubInformationBottom'>
                        <span class='tourFreePlaces'>Свободных мест: {$single_tour[freePlaces]}</span>
                        <a class='tourMoreHref' href='?tour={$single_tour[id]}' target='_blank'>Подробнее/Купить</a>
                    </div>
                </div>
            </section>
            <div class='tourBlockImg' style='float:$float_image'>
                <img src='../img/tours/{$single_tour[id]}/main.jpg' alt='tour image' class='tourImg' height='240' width='280' style='$img_style'>
                <div class='tourPrice'>{$single_tour[price]} &#8381; за чел.</div>
            </div>
        </div>
    </div>
    ";
    $i++;
}

if( !$i ){
    echo "
        <div id='tourWarning'>
            <strong>Извините, по вашему запросу еще нет туров!</strong>
            <img src='../img/warning.jpg' height='300' width='300'>
        </div>
    ";
}
