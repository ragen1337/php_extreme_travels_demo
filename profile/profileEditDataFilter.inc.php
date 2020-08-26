<?php
require_once "../inc/functions.inc.php";
require_once "../inc/constants.inc.php";
$edit_data_array = $_POST;

if( $edit_data_array != null){
    
    $flag = 1;
    foreach( $edit_data_array as $elem )
    if($elem == null || $elem == ""){
        $flag = 0;
        break;
    }
    
    if( $edit_data_array[mainInfoHidden] === 'main' ){
        try{
            if( !$flag ){
                throw new Exception("Есть незаполненные поля!");
            }elseif( strlen( $edit_data_array[name] ) > 40 ){
                throw new Exception("Слишком длинное имя!");
            }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $edit_data_array[name] ) ){
                throw new Exception("В имени недопустимые символы!");
            }elseif( strlen( $edit_data_array[surname] ) > 60 ){
                throw new Exception("Слишком длинная фамилия!");
            }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $edit_data_array[surname] ) ){
                throw new Exception("В фамилии недопустимые символы!");
            }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $edit_data_array[surname] ) ){
                throw new Exception("В фамилии недопустимые символы!");
            }elseif( strlen( $edit_data_array[country] ) > 60){
                throw new Exception("Слишком длинное название страны.");
            }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $edit_data_array[country] ) ){
                throw new Exception("В поле 'страна' недопустимые символы!");
            }elseif( strlen( $edit_data_array[city] ) > 60){
                throw new Exception("Слишком длинное название города.");
            }elseif( preg_match( '#[0-9~!@\#;$%\^:&*()_ +=]#' , $edit_data_array[city] ) ){
                throw new Exception("В поле 'город' недопустимые символы!");
            }elseif( ( !preg_match( '#\+?[0-9]{11,12}$#' , $edit_data_array[phoneNumber] ) ) ||
            ( strlen( $edit_data_array[phoneNumber] ) > 12 ) ){
                throw new Exception("Введён некорректный номер");
            }elseif( check_field_in_db( DB_INFO, DB_LOGIN, DB_PWD, "users", "email", $edit_data_array[email] ) && ( $edit_data_array[email] != $person_email ) ){
                throw new Exception("Такой email уже существует!");
            }
            $welcome = "<h2 id='profilePageWelcome' style='color:green'>Данные успешно изменены!</h2>";
            
            require_once "profileEditMainInfoDB.inc.php";
        }catch(Exception $e){
            $welcome = "<h2 id='profilePageWelcome' style='color:red'>{$e->getMessage()}</h2>";
        }
    }elseif( $edit_data_array[pwdHidden] === 'pwd' ){
        try{
            if( !$flag ){
                throw new Exception("Для смены пароля необходимо заполнить все поля!");
            }elseif( !password_verify( $edit_data_array[oldPwd], $person_pwd ) ){
                throw new Exception("Введён неверный пароль!");
            }elseif( strlen( $edit_data_array[newPwd1] ) <= 8 ){
                throw new Exception("Пароль должен быть длинне 8 символов!");
            }elseif( !preg_match( '#[a-z]#' , $edit_data_array[newPwd1] ) ||
            !preg_match( '#[A-Z]#' , $edit_data_array[newPwd1] ) ||
            !preg_match( '#[0-9]#' , $edit_data_array[newPwd1] ) ){
                throw new Exception("Пароль должен содержать a-z,A-Z,0-9 символы!");
            }elseif( $edit_data_array[newPwd1] != $edit_data_array[newPwd2] ){
                throw new Exception("Пароли не совпадают!");
            }
            $welcome = "<h2 id='profilePageWelcome' style='color:green'>Пароль удачно изменён!</h2>";
            
            require_once "profileEditPwdDB.inc.php";
        }catch(Exception $e){
            $welcome = "<h2 id='profilePageWelcome' style='color:red'>{$e->getMessage()}</h2>";
        }
    }
}
    