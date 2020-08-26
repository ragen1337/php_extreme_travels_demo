<?php
require_once "../inc/constants.inc.php";

if( $pdo == null )
    $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);

$hash_pwd = $pdo->quote( password_hash($edit_data_array[newPwd1], PASSWORD_DEFAULT) );
$quote_person_login = $pdo->quote( $person_login );

$query="UPDATE users
            SET
                pwd=$hash_pwd
            WHERE
                login=$quote_person_login";

$result = $pdo->query( $query );

if( !$result ){
    $welcome = "<h2 id='profilePageWelcome' style='color:red'>Ошибка сервера, повторите позже!</h2>";
}

header("refresh:1");