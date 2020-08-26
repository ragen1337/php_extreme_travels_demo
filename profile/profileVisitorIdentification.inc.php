<?php
require_once "../inc/authorisationCheckModule.inc.php";

if( $authorisation_confirmed ){
        
        $quote_login = $pdo->quote($login);
        
        $query = "SELECT * FROM users
                    WHERE login=$quote_login";
        
        $person_info_obj= $pdo->query($query);
        
        foreach( $person_info_obj as $field ){
            $person_login = $field[login];
            $person_email = $field[email];
            $person_name = $field[name];
            $person_surname = $field[surname];
            $person_birth_date = $field[birthDate];
            $person_country = $field[country];
            $person_city = $field[city];
            $person_status = $field[status];
            $person_phone_number = $field[phoneNumber];
            $person_pwd = $field[pwd];
        }
        
        $access = strtoupper( $person_status );
        
}else{
    $access = "DENIED";
}