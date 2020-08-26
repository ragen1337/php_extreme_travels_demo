<?php
require_once "toursFilterDrawing.inc.php";
require_once "toursGetInfoFromDB.inc.php";

?>

<section id='filterBlock'>
    <form action='' method='GET' id='filterForm'>
        <input type='hidden' name='page' value='tours'>
        <div class='filterBlock' id='filterBlock1'>
            <section id='kindOfSportSection'>
                <h4>Вид спорта:</h4>
                <select name='kindOfSport[]' id='kindOfSport' multiple size='4'>
                    <option>Все</option>
                    <? options_drawer( $distinct_kind_of_sport_arr, $_GET[kindOfSport] ); ?>
                </select>
            </section>
            <section id='countrySection'>
                <h4>Страна:</h4>
                <select name='country[]' id='country' multiple size='4'>
                    <option>Все</option>
                    <option>Зарубежные</option>
                    <? options_drawer( $distinct_country_arr , $_GET[country] ); ?>
                </select>
            </section>
        </div>
        <div class='filterBlock' id='filterBlock2'>
            <section id='travelDate'>
                <h4>Дата путешествия:</h4>
                <section id='from'>
                    <h4>С:</h4>
                    <input type='date' name='dateFrom' min='<?=date('Y-m-d' ,time() )?>' max='<?=date('Y-m-d' ,time() + 157680000 )?>' value='<?=$_GET[dateFrom]?>' id='fromInput'>
                </section>
                <section id='to'>
                    <h4>По:</h4>
                    <input type="date" name='dateTo' min='<?=date('Y-m-d' ,time() )?>' max='<?=date('Y-m-d' ,time() + 157680000 )?>' value='<?=$_GET[dateTo]?>' id='toInput'>
                </section>
            </section>
        </div>
        <div class='filterBlock' id='filterBlock3'>
            <section id='maxPriceSection'>
                <h4>Максимальная цена за человека(&#8381;):</h4>
                <input type="number" id='maxPriceInput' name='maxPrice' max='1000000' min='1' value='<?=$_GET[maxPrice]?>'>
            </section>
            <section id='amountOfPeopleSection'>
                <h4>Количество человек:</h4>
                <input type="number" name='amountOfPeople' max='100' min='1' id='amountOfPeople' value='<?=$_GET[amountOfPeople]?>'>
            </section>
        </div>
        <div class='filterBlock' id='filterBlock4'>
            <input type='submit' id='filterSubmit' value='Найти'>
        </div>
    </form>
    <span id='filterNote'>*Зажмите left ctrl, чтоб выбрать несколько вариантов.</span>
</section>

<?
require_once "toursDrawing.inc.php";
?>