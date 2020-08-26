<?php
require_once "../inc/constants.inc.php";

if( $pdo == null )
    $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);

$quote_email = $pdo->quote( $edit_data_array[email] );
$quote_birth_date = $pdo->quote( $edit_data_array[birthDate] );
$quote_name = $pdo->quote( $edit_data_array[name] );
$quote_surname = $pdo->quote( $edit_data_array[surname] );
$quote_city = $pdo->quote( $edit_data_array[city] );
$quote_country = $pdo->quote( $edit_data_array[country] );
$quote_phone_number = $pdo->quote( $edit_data_array[phoneNumber] );

$quote_person_login = $pdo->quote( $person_login );

$query = "UPDATE users
            SET
                email=$quote_email,
                birthDate=$quote_birth_date,
                name=$quote_name,
                surname=$quote_surname,
                country=$quote_country,
                city=$quote_city,
                phoneNumber=$quote_phone_number
            WHERE
                login=$quote_person_login";

$result = $pdo->query( $query );

if( !$result ){
    $welcome = "<h2 id='profilePageWelcome' style='color:red'>Ошибка сервера, повторите позже!</h2>";
}

header("refresh:1");