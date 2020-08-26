<?php
require_once "menuArray.inc.php";

//drawing top || bottom menu
function draw_menu( $menu_type, $menu_arr ){//top || bottom
    $menu_array = $menu_arr;
    $type = $menu_type;
    if( ($type != 'top') || ($type != 'bottom') ){
        $type = "top";
    }
    
    echo "<ul class='" . $type . "Menu'>"; // class = topMenu || class = bottomMenu
        $count = 0;
        foreach( $menu_array as $menu_li ){
            if( $menu_li[submenu] == null){
                echo "<li id='" . $type . $count . "MenuLi' class='" . $type . "MenuLi'>
                        <a href='http://localhost" . $menu_li[href] . "'>" . $menu_li[name] . "</a>
                    </li>";
            }else{
                echo "<li id='" . $type . $count . "MenuLi' class='" . $type . "MenuLi'>
                        <a href='http://localhost" . $menu_li[href] . "'>" . $menu_li[name] . "</a>
                            <ul class='" . $type . "SubMenu'>";
                                foreach( $menu_li[submenu] as $sub_menu_li ){
                                    echo "<li class='" . $type . "SubMenuLi'>
                                            <a href='http://localhost" . $sub_menu_li[href] . "'>" . $sub_menu_li[name] . "</a>
                                        </li>";
                                }
                        echo "</ul>
                    </li>";
            }
            $count++;
        }
    
    echo "</ul>";
}

// first symbol to upper & another symbols to lower
function str_to_db($string){
    return ucfirst( strtolower( $string ) );
}

//switcher for authorisation bar
function authorisation_bar_switcher($flag){
    if(!$flag){
        echo   
        "<div id='registrationOrUsername'>
            <a href='registration.php'>Регистрация</a>
        </div>
        <div id='authorisationOrExit'>
            <a href='authorisation.php'>Вход</a>
        </div>";
    }else{
        echo   
        "<div id='registrationOrUsername'>
            <a href='../profile/profile.php'>Кабинет</a>
        </div>
        <div id='authorisationOrExit'>
            <a href='?logout=1'>Выход</a>
        </div>";
    }
}

//switch pages
function page_switcher( $page, $title_flag , $tour_flag ){
        if( !$title_flag && $tour_flag ){
            require_once "tourPage.inc.php";
        }elseif( !$title_flag ){   
            require_once "error404.inc.php";
        }elseif( $page == "" ){
            require_once "main.inc.php";
        }else{
            require_once "$page.inc.php";
        }
}

//checks the field for existence in db sheet
function check_field_in_db($db_info, $db_login, $db_pwd, $sheet, $field_header, $field){
    if( $pdo == NULL )
        $pdo = new PDO(DB_INFO, DB_LOGIN, DB_PWD);
    
    $quote_field = $pdo->quote( $field );
    $query = "SELECT id FROM $sheet
                WHERE $field_header=$quote_field";
    
    $result = $pdo->query($query);
    
    foreach($result as $elem){
        $query_value = $elem[id];
    }
    
    if( $query_value == NULL ){
        return 0;
    }else{
        return 1;
    }
}

//return 1 value from db sheet
function content_drawing($db_info, $db_login, $db_pwd, $sheet, $field_header, $field, $value_header){
    if( $pdo == NULL )
        $pdo = new PDO($db_info, $db_login, $db_pwd);
    
    $quote_field = $pdo->quote( $field );
    $query = "SELECT $value_header FROM $sheet
                WHERE $field_header=$quote_field";
    
    $result = $result = $pdo->query($query);
    
    foreach( $result as $elem ){
        $value = $elem[$value_header];
    }
    
    return $value;
}

//drawing tour types sections in  main.inc.php
function tour_types_drawing( $headers_array, $descriptions_array , $hrefs_array){
    $i = 1;
    foreach( $headers_array as $elem ){
        echo 
        "
        <section class='tourTypes' id='tourTypes$i'>
            <a href='{$hrefs_array[$i-1]}' class='tourTypesHeaderHref'><h3 class='tourTypesHeader' id='tourTypesHeader$i'>{$headers_array[ $i-1 ]}</h3></a>
            <div class='sliderBlock' id='sliderBlock$i'>
                <button class='mainPageButton1'><span class='mainPageButtonQuotes'>&laquo;</span></button>
                <img src='../img/tourTypesImage{$i}_1.jpg' alt='image$i' id='tourTypesImage$i' width='180' height='180'>
                <button class='mainPagebutton2'><span class='mainPageButtonQuotes'>&raquo;</span></button>
                <article class='tourTypesDescription' id='tourTypesDescription$i'>
                    {$descriptions_array[ $i-1 ]}
                </article>
            </div>
        </section>
        ";
        $i++;
    }
}

//drawing sections in mainPageBottomBar
function main_page_bottom_bar_drawing( $hrefs_array, $headers_array ){
    $i = 1;
    
    foreach( $hrefs_array as $elem ){
        echo
        "
        <section class='mainPageBottomBarElem' id='mainPageBottomBarElem$i'>
            <a href='{$hrefs_array[$i-1]}' class='mainPageBottomBarElemHref'>
                <img src='../img/mainPageBottomBarImg$i.jpg' alt='Фото$i' width='160' height='160' class='mainPageBottomBarElemImg'>
            </a>
            <a href='{$hrefs_array[$i-1]}' class='mainPageBottomBarElemHeaderHref'>
                <h4 class='mainPageBottomBarElemHeader' id='mainPageBottomBarElemHeader$i'>{$headers_array[$i-1]}</h4>
            </a>
        </section>
        ";
        $i++;
    }
}

//drawing options from array for select-block (tours.inc)
function options_drawer( $values_array , $get_values_array ){
    foreach( $values_array as $elem){
        $flag = 0;
        foreach( $get_values_array as $get_elem){
            if( $get_elem == $elem ){
                $flag = 1;
                break;
            }
        }
        
        if( $flag ){
            echo "
                <option selected>$elem</option>
            ";  
        }else{
            echo "
                <option>$elem</option>
            ";
        }
    }
}

//return array (string which drawing photos and approximate height of block with this photos)
function tour_page_photo_drawer( $directory , $tour_id ){
    $counter = 0;
    $draw_photo_string = null;
    foreach( $directory as $elem ){
        if($elem == '.' || $elem == '..'){
            continue;
        }else{
            $counter++;
            $draw_photo_string .= "
                <img src='../img/tours/$tour_id/$elem' alt='photo' height='200' width='300' class='tourPagePhotos'>
            ";
        }
    }
    
    $partial_height = ceil($counter/3) * 226;
    
    $array = [ $draw_photo_string, $partial_height];
    return $array;
}

//checks if the photo is too large, uploaded and in photo format
function photo_validator( $uploaded_file_array, $file_type = 'image/jpeg' ){
        if( !is_uploaded_file( $uploaded_file_array['tmp_name'] ) ){
            return 0;
        }
        if( $uploaded_file_array['size'] > 5000000 ){
            return 0;
        }
        if( $uploaded_file_array['type'] != $file_type ){
            return 0;
        }
    
        return 1;
}

//