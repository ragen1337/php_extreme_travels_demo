<?php
require_once "constants.inc.php";
require_once "functions.inc.php";

if( $pdo == null )
    $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);

$distinct_kind_of_sport_query = "SELECT DISTINCT kindOfSport FROM tours WHERE status='active' ORDER BY kindOfSport ";

$distinct_kind_of_sport_obj = $pdo->query( $distinct_kind_of_sport_query );

$i = 0;
foreach( $distinct_kind_of_sport_obj as $elem ){
    $distinct_kind_of_sport_arr[$i] = $elem[0];
    $i++;
}


$distinct_country_query = "SELECT DISTINCT country FROM tours WHERE status='active' ORDER BY country";

$distinct_country_obj = $pdo->query( $distinct_country_query );

$i = 0;
foreach( $distinct_country_obj as $elem ){
    $distinct_country_arr[$i] = $elem[0];
    $i++;
}