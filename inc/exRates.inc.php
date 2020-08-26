<?php
    $languages = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp");
    if( isset($_COOKIE["cursvalut"]) ){ 
        $koeficient1a = $_COOKIE["cursvalut"]; 
    }else{
        //валюты
        foreach ($languages->Valute as $lang){
            if($lang["ID"] == 'R01235') { //тип валюты
                $koeficient1 = round(str_replace(',','.',$lang->Value), 2); //ее значение
                $koeficient1a = $lang->Nominal . ' ' . $lang->Name . ' = ' . $koeficient1 . ' руб.<br>'; //запоминаем номинал
            } //в куках
            if($lang["ID"] == 'R01239') { //тип валюты
                $koeficient1 = round(str_replace(',','.',$lang->Value), 2);
                $koeficient1a = $koeficient1a . $lang->Nominal . ' ' . $lang->Name. ' = ' . $koeficient1 . ' руб.<br>';
            } 
            setcookie("cursvalut",$koeficient1a,time()+3600*12);
        }
    }