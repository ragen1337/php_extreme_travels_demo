<?php
    require_once "constants.inc.php";

    if( $pdo == null )
        $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);
        
    
    
    $login = $pdo->quote( $registration_data_array[login]) ;
    $hash_pwd = $pdo->quote( password_hash($registration_data_array[pwd1], PASSWORD_DEFAULT) );
    $email = $pdo->quote( $registration_data_array[email] );
    $name = $pdo->quote( $registration_data_array[name] );
    $surname = $pdo->quote( $registration_data_array[surname] );
    $birthDate = $pdo->quote( $registration_data_array[birthDate] );
    $contry = $pdo->quote( $registration_data_array[country] );
    $city = $pdo->quote( $registration_data_array[city] );
    $phoneNumber = $pdo->quote( $registration_data_array[phoneNumber] );
    $status = $pdo->quote( 'user' );
    $token = password_hash("To2K32eaN31965aaToKeN4", PASSWORD_DEFAULT);
    $quote_token = $pdo->quote( $token );
    
    $query ="INSERT INTO users
                VALUES(NULL, $login, $hash_pwd, $email, $name, $surname, $birthDate, $contry, $city, $phoneNumber, $status, $quote_token)";
    
    $result = $pdo->exec($query);

    if( $result == 0 ){
        throw new Exception("Проблемы с сервером, повторите позже!");
    }else{
        setcookie("login", $registration_data_array[login] , time()+86400);
        setcookie("token", $token, time()+86400);
        header("refresh:1;url=index.php");
    }
    
    
        