<?php 
require_once "menuArray.inc.php";

if( empty( $_GET[tour] ) ){
    $is_it_tour = false;
    $page_now = $_GET['page'];
    if( $_GET['page'] == null ){
        $page_now="";
    }
    $query_string_page_now = "?page=" . $page_now;

    //Iterating over an array and check with menu points
    foreach( $menuArray as $menuArrayItem ){
        if( ( $menuArrayItem[submenu] == null )&&
        ( ( $menuArrayItem[href] == $page_now )||( $menuArrayItem[href] == $query_string_page_now ) ) ){
            $title = $menuArrayItem[name];
            $title_flag = 1;
            break;
        }
        if( $menuArrayItem[submenu] != null ){
            foreach( $menuArrayItem[submenu] as $subMenuArrayItem ){
                if( ($subMenuArrayItem[href] == $page_now)||($subMenuArrayItem[href] == $query_string_page_now) ){
                    $title = $subMenuArrayItem[name];
                    $title_flag = 1;;
                    break 2;
                }
            }
        }
        $title = "Страницы не существует!";
        $title_flag = 0;
    }
}else{
    $is_it_tour = true;
}