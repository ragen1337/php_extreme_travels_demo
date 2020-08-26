<?php
    require_once "functions.inc.php";
    require_once "constants.inc.php";
    
    $registration_data_array = $_POST;
    $flag = 1;
    foreach($registration_data_array as $elem)
        if($elem == null || $elem == ""){
            $flag = 0;
            break;
        }

    try{
        $color_msg = "firebrick";
        if( $registration_data_array == null || $flag == 0 ){
            throw new Exception("Заполните поля ниже:");
        }elseif( strlen($registration_data_array[name]) > 40 ){
            throw new Exception("Слишком длинное имя!");
        }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $registration_data_array[name] ) ){
            throw new Exception("В имени недопустимые символы!");
        }elseif( strlen( $registration_data_array[surname] > 60 ) ){
            throw new Exception("Слишком длинная фамилия!");
        }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $registration_data_array[surname] ) ){
            throw new Exception("В фамилии недопустимые символы!");
        }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $registration_data_array[surname] ) ){
            throw new Exception("В фамилии недопустимые символы!");
        }elseif( strlen( $registration_data_array[country] ) > 60){
            throw new Exception("Слишком длинное название страны.");
        }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $registration_data_array[country] ) ){
            throw new Exception("В поле 'страна' недопустимые символы!");
        }elseif( strlen( $registration_data_array[city] ) > 60){
            throw new Exception("Слишком длинное название города.");
        }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $registration_data_array[city] ) ){
            throw new Exception("В поле 'город' недопустимые символы!");
        }elseif( ( !preg_match( '#\+?[0-9]{11,12}$#' , $registration_data_array[phoneNumber] ) ) ||
        ( strlen( $registration_data_array[phoneNumber] ) > 12 ) ){
            throw new Exception("Введён некорректный номер");
        }elseif( check_field_in_db( DB_INFO, DB_LOGIN, DB_PWD, "users", "login", $registration_data_array[login] ) ){
            throw new Exception("Такой логин уже существует!");
        }elseif( check_field_in_db( DB_INFO, DB_LOGIN, DB_PWD, "users", "email", $registration_data_array[email] )){
            throw new Exception("Такой email уже существует!");
        }elseif( strlen( $registration_data_array[pwd1] ) <= 8 ){
            throw new Exception("Пароль должен быть длинне 8 символов!");
        }elseif( !preg_match( '#[a-z]#' , $registration_data_array[pwd1] ) ||
        !preg_match( '#[A-Z]#' , $registration_data_array[pwd1] ) ||
        !preg_match( '#[0-9]#' , $registration_data_array[pwd1] ) ){
            throw new Exception("Пароль должен содержать a-z,A-Z,0-9 символы!");
        }elseif($registration_data_array[pwd1] != $registration_data_array[pwd2]){
            throw new Exception("Пароли не совпадают!");
        }
        
        require_once "registrationDB.inc.php";
        
        $message = "Вы успешно зарегистрировались!";
        $color_msg = "green";
    }catch(Exception $e){
        $message = $e->getMessage();
    }
    