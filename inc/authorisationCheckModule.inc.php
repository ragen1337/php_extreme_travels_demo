<?php
    require_once "constants.inc.php";
    
    $authorisation_confirmed = FALSE;
    $login = $_COOKIE[login];
    $token = $_COOKIE[token];
    
    if( $_GET[logout] == 1 ){
        setcookie("login", $registration_data_array[login] , time()-86400);
        setcookie("token", $token, time()-86400);
        header("refresh:1;url=index.php");
    }

    if( ( $login != NULL ) && ( $token != NULL) ){
        if( $pdo == NULL )
            $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);

        $quote_login = $pdo->quote( $login );

        $check_query = "SELECT token FROM users
                        WHERE login=$quote_login";
        $check_result = $pdo->query( $check_query );


        if( $check_result && ($token != "") ){
            foreach($check_result as $elem){
                    $db_user_token = $elem[token];
            }
            if( $db_user_token == $token ){
                $authorisation_confirmed = TRUE;
            }
        }
    }