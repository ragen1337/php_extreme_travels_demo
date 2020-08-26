<?php
require "constants.inc.php";
if( $pdo == null )
    $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);

$query ="SELECT * FROM tours WHERE status='active'";

$get_array_keys = array_keys( $_GET );

for( $i = 0; $i < count( $get_array_keys ); $i++ ){
    if( $get_array_keys[$i] == 'page' ){
        continue;
    }
    elseif( $get_array_keys[$i] == 'kindOfSport' ){
        if( ( count( $_GET[ $get_array_keys[$i] ] ) ) == 1){
            if( ( $_GET[ $get_array_keys[$i] ][0] == 'Все' ) || ( !$_GET[ $get_array_keys[$i] ][0] ) ){
                continue;
            }else{
                $query .= " AND kindOfSport={$pdo->quote( $_GET[ $get_array_keys[$i] ][0] )}";
            }
        }
        elseif( ( count( $_GET[ $get_array_keys[$i] ] ) ) > 1){
            if( ( $_GET[ $get_array_keys[$i] ][0] == 'Все' ) || ( !$_GET[ $get_array_keys[$i] ][0] ) ){
                continue;
            }else{
                $query .= " AND (kindOfSport={$pdo->quote( $_GET[ $get_array_keys[$i] ][0] )}";
                for($j = 1; $j < count( $_GET[ $get_array_keys[$i] ] ); $j++){
                    $query .= " OR kindOfSport={$pdo->quote( $_GET[ $get_array_keys[$i] ][$j] )}";
                }
                $query .= ")";
            }
        }
    }
    elseif( $get_array_keys[$i] == 'country' ){
        if( ( count( $_GET[ $get_array_keys[$i] ] ) ) == 1){
            if( ( $_GET[ $get_array_keys[$i] ][0] == 'Все' ) || ( !$_GET[ $get_array_keys[$i] ][0] ) ){
                continue;
            }elseif($_GET[ $get_array_keys[$i] ][0] == 'Зарубежные'){
                $query .= " AND NOT country='Россия'";
            }else{
                $query .= " AND country={$pdo->quote( $_GET[ $get_array_keys[$i] ][0] )}";
            }
        }
        elseif( ( count( $_GET[ $get_array_keys[$i] ] ) ) > 1){
            if( ( $_GET[ $get_array_keys[$i] ][0] == 'Все' ) || ( !$_GET[ $get_array_keys[$i] ][0] ) ){
                continue;
            }elseif( $_GET[ $get_array_keys[$i] ][1] == 'Россия' ){
                $query .= " AND NOT country='Россия'";
                continue;
            }else{
                $query .= " AND (country={$pdo->quote( $_GET[ $get_array_keys[$i] ][0] )}";
                for($j = 1; $j < count( $_GET[ $get_array_keys[$i] ] ); $j++){
                    $query .= " OR country={$pdo->quote( $_GET[ $get_array_keys[$i] ][$j] )}";
                }
                $query .= ")";
            }
        }
    }
    elseif( $get_array_keys[$i] == 'dateFrom' ){
        if( ( !$_GET[ $get_array_keys[$i] ] ) ){
            continue;
        }else{
            $query .= " AND dateFrom >={$pdo->quote( $_GET[ $get_array_keys[$i] ] )}";  
        }
    }
    elseif( $get_array_keys[$i] == 'dateTo' ){
        if( ( !$_GET[ $get_array_keys[$i] ] ) ){
            continue;
        }else{
            $query .= " AND dateTo <= {$pdo->quote( $_GET[ $get_array_keys[$i] ] )}";
        }
    }
    elseif( $get_array_keys[$i] == 'maxPrice' ){
        if( ( !$_GET[ $get_array_keys[$i] ] ) ){
            continue;
        }else{
            $query .= " AND price <= {$pdo->quote( (int)$_GET[ $get_array_keys[$i] ] )}";
        }
    }
    elseif( $get_array_keys[$i] == 'amountOfPeople' ){
        if( ( !$_GET[ $get_array_keys[$i] ] ) ){
            continue;
        }else{
            $query .= " AND freePlaces >= {$pdo->quote( (int)$_GET[ $get_array_keys[$i] ] )}";
        }
    }
}


$tours_all_info = $pdo->query( $query );
