<?php
    require_once "constants.inc.php";
    
    try{
        $color_msg = "firebrick";
        if( ( $_POST[login] == null ) || 
        ( $_POST[login] == "" ) || 
        ( $_POST[pwd] == null ) || 
        ( $_POST[pwd] == "") ){
            throw new Exception("Введите логин и пароль:");
        }
        
        if( $pdo == null )
            $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);

        $login = $pdo->quote( $_POST[login] );
        $pwd = $_POST[pwd];

        $query ="SELECT pwd FROM users
                    WHERE login=$login";
        $result = $pdo->query($query);

        foreach($result as $elem){
            $db_user_pwd = $elem[pwd];
        }

        if( !password_verify( $pwd, $db_user_pwd ) ){
            throw new Exception("Неправильный логин или пароль!");
        }
        
        $color_msg = "green";
        $message = "Авторизация прошла успешно!";
        
        $token = ( password_hash("To2K32eaN31965aaToKeN4", PASSWORD_DEFAULT) );
        $quote_token = $pdo->quote( $token );

        
        $query2= "UPDATE users
                    SET token=$quote_token
                    WHERE login=$login";
        $result2 = $pdo->exec($query2);
        if($result2 == 0){
            throw new Exception("Проблемы с сервером, попробуйте авторизоваться позже.");
        }
        
        setcookie("login", $_POST[login], time()+86400);
        setcookie("token", $token, time()+86400);
        header("refresh:1;url=index.php");
        
    }catch(Exception $e){
        $message = $e->getMessage();
    }
    