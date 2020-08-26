<?
require_once "profileVisitorIdentification.inc.php";
require_once "../inc/functions.inc.php";

if( isset( $_POST['tourId'] ) ){
    $quoted_tour_id = $pdo->quote( $_POST['tourId'] );
}
    
if( $access == "AGENCY" ){
    $check_query = "SELECT owner FROM tours
                        WHERE id=$quoted_tour_id";
    
    $owner_obj = $pdo->query( $check_query );
    
    foreach( $owner_obj as $owner ){
        $tour_owner_name = $owner['owner'];
    }
}

if( $tour_owner_name == $person_login || $access == "ADMIN" ){
    
    if( $_POST['changeType'] == 'mainInfo' ){
        $empty_field_flag = 0;
        foreach( $_POST as $elem ){
            if( empty($elem) ){
                $empty_field_flag = 1;
                break;
            }
        }
        
        if( $empty_field_flag ){
            $warning = "Не удалось внести изменения!";
        }else{
            $quoted_name = $pdo->quote($_POST['changeName']);
            $quoted_kind_of_sport = $pdo->quote($_POST['changeKindOfSport']);
            $quoted_date_from = $pdo->quote($_POST['changeDateFrom']);
            $quoted_date_to = $pdo->quote($_POST['changeDateTo']);
            $quoted_country = $pdo->quote($_POST['changeCountry']);
            $quoted_city = $pdo->quote($_POST['changeCity']);
            $quoted_price = $pdo->quote($_POST['changePrice']);
            $quoted_free_places = $pdo->quote($_POST['changeFreePlaces']);
            $quoted_status = $pdo->quote($_POST['changeStatus']);

            $quoted_description = $pdo->quote( str_replace( PHP_EOL , '<br>', $_POST['changeDescription']) );
            $quoted_terms = $pdo->quote( str_replace( PHP_EOL , '<br>', $_POST['changeTerms']) );

            $query = "UPDATE tours
                        SET
                            name=$quoted_name,
                            description=$quoted_description,
                            terms=$quoted_terms,
                            kindOfSport=$quoted_kind_of_sport,
                            freePlaces=$quoted_free_places,
                            dateFrom=$quoted_date_from,
                            dateTo=$quoted_date_to,
                            country=$quoted_country,
                            city=$quoted_city,
                            price=$quoted_price,
                            status=$quoted_status
                        WHERE
                            id=$quoted_tour_id";

            $query_result = $pdo->exec( $query );

            if( !$query_result ){
                $warning = "Данные не были изменены!";
            }
        }
        
        header("refresh:1;url=cabinet.php?editTour={$_POST['tourId']}");
    }elseif( $_POST['changeType'] == 'mainPhoto' ){
        if( !photo_validator( $_FILES['mainPhotoFile'] ) ){
            $warning = "Не удалось загрузить фото";
        }else{
            $photo_moving = move_uploaded_file( $_FILES['mainPhotoFile']['tmp_name'], "../img/tours/{$_POST['tourId']}/main.jpg" );
            
            if( !$photo_moving ){
                $warning = "Не удалось зменить фото!";
            }
        }
        
        header("refresh:1;url=cabinet.php?editTour={$_POST['tourId']}");
    }elseif( $_POST['changeType'] == 'deletePhotos' ){
        if( isset( $_POST['deletePhotos'] ) ){ 
            foreach( $_POST['deletePhotos'] as $photo ){
                $unlink_result = unlink( "../img/tours/{$_POST['tourId']}/$photo" );
                
                if( !$unlink_result ){
                    $warning = "Не удалось удалить фотографии";
                }
            }
        }else{
            $warning = "Выберите фотографии, которые хотите удалить!";
        }
        
        header("refresh:1;url=cabinet.php?editTour={$_POST['tourId']}");
    }elseif( $_POST['changeType'] == 'uploadPhotos' ){
        for($i = 0; $i < count( $_FILES['photoCollage']['name'] ); $i++){
            $file_array['tmp_name'] = $_FILES['photoCollage']['tmp_name'][$i];
            $file_array['size'] = $_FILES['photoCollage']['size'][$i];
            $file_array['type'] = $_FILES['photoCollage']['type'][$i];
            $file_array['name'] = $_FILES['photoCollage']['name'][$i];
            if( !photo_validator( $file_array ) ){
                $warning = "Не удалось загрузить фото: {$file_array['name']}";
            }else{
                $move_photos = move_uploaded_file( $_FILES['photoCollage']['tmp_name'][$i], "../img/tours/{$_POST['tourId']}/{$file_array['name']}" );
                
                if( !$move_photos ){
                    $warning = "Не удалось загрузить фотографии";
                }
            }
        }
        
        header("refresh:1;url=cabinet.php?editTour={$_POST['tourId']}");
    }elseif( $_POST['changeType'] == 'deleteTour'){
        $query = "UPDATE tours
                    SET
                        status='deleted'
                    WHERE
                        id=$quoted_tour_id";
        $delete_tour_result = $pdo->exec( $query );
        
        if( !$delete_tour_result ){
            $warning = "Тур не был изменён!";
        }
        
        header("refresh:1;url=cabinet.php");
    }
}

if( $access == "ADMIN" ){
    if( isset( $_POST['editHeader'] ) ){
        if( $_POST['editHeader'] == 'headerImage'){
            if( !photo_validator( $_FILES['headerImageFile'] ) ){
                $warning = "Не удалось загрузить фото";
            }else{
                $move_header_image = move_uploaded_file( $_FILES['headerImageFile']['tmp_name'] , "../img/headerImg.jpg" );
                
                if( !$move_header_image ){
                    $warning = "Не удалось загрузить фотографии";
                }
            }
        }
        
        if( $_POST['editHeader'] == 'logoImage'){
            if( !photo_validator( $_FILES['headerLogoFile'], 'image/png' ) ){
                $warning = "Не удалось загрузить фото";
            }else{
                $move_logo_image = move_uploaded_file( $_FILES['headerLogoFile']['tmp_name'] , "../img/logo.png" );
                
                if( !$move_logo_image ){
                    $warning = "Не удалось загрузить фотографии";
                }
            }
        }
        
        if( $_POST['editHeader'] == 'headerInfo' ){
            $quoted_header_info = $pdo->quote( str_replace( PHP_EOL, '<br>', $_POST[ 'headerInfoText' ] ) );
            $query = "UPDATE content
                        SET 
                            content=$quoted_header_info
                        WHERE
                            html_id='headerInfo'";
            $res = $pdo->exec( $query );
        }
        
        header("refresh:1;url=cabinet.php?editPage=header");
    
    }elseif( isset( $_POST['editMainPage']) ){
        if( $_POST['editMainPage'] == 'blocksInfo' ){
            $tour_types_number = (int)$_POST['blockNumber'];
            
            $tour_types_header = $pdo->quote( $_POST["changeMainPageHeader$tour_types_number"] );
            $tour_types_header_href = $pdo->quote( $_POST["changeMainPageHeaderHref$tour_types_number"] );
            $tour_types_description = $pdo->quote( str_replace( PHP_EOL, "<br>", $_POST["changeMainPageDescription$tour_types_number"] ) );
            
            
            $header_query =    "UPDATE content
                                    SET content=$tour_types_header
                                WHERE
                                    html_id='tourTypesHeader$tour_types_number'";
            $res1 = $pdo->exec( $header_query );
            if( !$res1 )
                $warning.= "Заголовок не был изменён!<br>";
            
            $header_href_query =   "UPDATE content
                                        SET href=$tour_types_header_href
                                    WHERE
                                        html_id='tourTypesHeader$tour_types_number'";
            $res2 = $pdo->exec( $header_href_query );
            if( !$res2 )
                $warning.= "Ссылка не была изменена!<br>";
            
            $description_query =   "UPDATE content
                                        SET content=$tour_types_description
                                    WHERE
                                        html_id='tourTypesDescription$tour_types_number'";
            $res3 = $pdo->exec( $description_query );
            if( !$res3 )
                $warning.= "Описание не было изменено!<br>";
        }
        
        if( $_POST['editMainPage'] == 'blocksImages' ){
            $tour_types_images = array_keys($_FILES);
            
            foreach( $tour_types_images as $image ){
                if( empty( $_FILES[$image]['size'] ) ){
                    continue;
                }else{
                    if( !photo_validator( $_FILES[$image] ) ){
                        $warning .= "Не удалось загрузить фото $image <br>" ;
                    }else{
                        $move_tour_types_image = move_uploaded_file( $_FILES[$image]['tmp_name'] , "../img/$image.jpg" );

                        if( !$move_tour_types_image ){
                            $warning .= "Не удалось загрузить фото $image <br>";
                        }
                    }
                }
            }
        }
        
        if( $_POST['editMainPage'] == 'bottomBar' ){
            $bottom_bar_html_ids = array_keys($_POST);
            
            foreach( $bottom_bar_html_ids as $html_id ){
                if( $html_id == 'editMainPage' )
                    continue;
                
                if( $html_id == 'mainPageBottomBarHeader' ){
                    $bottom_bar_header = $pdo->quote( $_POST[$html_id] );
                    $query ="UPDATE content
                                SET content=$bottom_bar_header
                            WHERE
                                html_id='mainPageBottomBarHeader'";
                    $res = $pdo->exec($query);
                    
                    if( !$res )
                        $warning .= "Заголовок не был изменён!<br>";
                }
                
                if( stristr( $html_id , 'mainPageBottomBarElemHref' ) ){
                    $quoted_html_id = $pdo->quote( $html_id ); 
                    $quoted_href = $pdo->quote( $_POST[$html_id] );
    
                    $query ="UPDATE content
                                SET href=$quoted_href
                            WHERE
                                html_id=$quoted_html_id";
                    $res = $pdo->exec($query);
                    
                    if( !$res )
                        $warning .= "Ссылка не была изменена!<br>"; 
                }
                
                if( stristr( $html_id , 'mainPageBottomBarElemHeader' ) ){
                    $quoted_html_id = $pdo->quote( $html_id ); 
                    $quoted_header = $pdo->quote( $_POST[$html_id] );
                    
                    $query ="UPDATE content
                                SET content=$quoted_header
                            WHERE
                                html_id=$quoted_html_id";
                    
                    $res = $pdo->exec($query);
                    
                    if( !$res )
                        $warning .= "Заголовок не был изменён!<br>"; 
                }
                
                $bottom_bar_images = array_keys($_FILES);
                
                foreach( $bottom_bar_images as $image ){
                    if( empty( $_FILES[$image]['size'] ) ){
                        continue;
                    }else{
                        if( !photo_validator( $_FILES[$image] ) ){
                            $warning .= "Не удалось загрузить фото $image <br>" ;
                        }else{
                            $move_tour_types_image = move_uploaded_file( $_FILES[$image]['tmp_name'] , "../img/$image.jpg" );

                            if( !$move_tour_types_image ){
                                $warning .= "Не удалось загрузить фото $image <br>";
                            }
                        }
                    }
                }
            
            }
            
        }
        
        if( $_POST['editMainPage'] == 'advertising' ){
            $advertising_href = $pdo->quote( $_POST['mainAdvertisingHref'] );
            
            $query="UPDATE content
                        SET href=$advertising_href
                    WHERE
                        html_id='mainAdvertisingHref'";
            
            $res = $pdo->exec( $query );
            if( !$res )
                $warning .= "Ссылка на рекламу не была изменена!<br>";
            
            if( !empty( $_FILES['mainAdvertising'] ) ){
                if( !photo_validator( $_FILES['mainAdvertising'] ) ){
                        $warning .= "Не удалось загрузить фото рекламы! <br>" ;
                }else{
                    $move_tour_types_image = move_uploaded_file( $_FILES['mainAdvertising']['tmp_name'] , "../img/mainAdvertising.jpg" );
                    if( !$move_tour_types_image ){
                        $warning .= "Не удалось загрузить фото рекламы! <br>";
                    }
                }
            }
            
        }
        
        header("refresh:1;url=cabinet.php?editPage=main");
    }elseif( isset( $_POST['editCommonInfo'] ) ){
        if( $_POST['editCommonInfo'] == 'all' ){
            $post_keys = array_keys( $_POST );
                foreach( $post_keys as $key ){
                    if( stristr( $key , 'commonInfoArticle' ) ){
                        $quoted_content = $pdo->quote( str_replace( PHP_EOL , '<br>', $_POST[$key] ) );
                    }else{
                        $quoted_content = $pdo->quote( $_POST[$key] );
                    }
                    $quoted_key = $pdo->quote( $key );
                    
                    $query = "UPDATE content
                                SET 
                                    content=$quoted_content
                                WHERE
                                    html_id=$quoted_key";
                    $res = $pdo->query( $query );
                    
                    if( !$res )
                        $warning .= "$key не было изменено<br>";
                }
        }
        
        header("refresh:1;url=cabinet.php?editPage=commonInfo");
    }elseif( isset( $_POST['editCooperation'] ) ){
        if( $_POST['editCooperation'] == 'mainInfo' ){
            foreach( $_POST as $key => $elem ){
                if( $key == 'editCooperation' ){
                    continue;
                }
                
                if( stristr( $key , 'cooperationArticle' ) ){
                    $quoted_content = $pdo->quote( str_replace( PHP_EOL , '<br>', $elem ) );
                }else{
                    $quoted_content = $pdo->quote( $elem );
                }                          
                $quoted_html_id = $pdo->quote( $key );
                
                
                $query = "UPDATE content
                            SET
                                content=$quoted_content
                            WHERE
                                html_id=$quoted_html_id";
                $res = $pdo->exec( $query );
                
                if( !$res )
                    $warning .= "$key не было изменено<br>";
            }
        }
        
        if( $_POST['editCooperation'] == 'priceList' ){
            $sxml_pricelist_obj = simplexml_load_file( '../xml/pricelist.xml' );
            foreach( $sxml_pricelist_obj as $elem ){
                if( $elem->id == $_POST['productId'] ){
                    $elem->title = $_POST['productTitle'];
                    $elem->price = $_POST['productPrice'];
                }
            }
            
            
            
            $res = file_put_contents( '../xml/pricelist.xml', $sxml_pricelist_obj->asXML() );
            
            if( !$res )
                $warning .= "Не удалось изменить пункт. <br>";
        }
        
        if( $_POST['editCooperation'] == 'priceListDeleteLast' ){
            $dom = new DomDocument();
            $dom ->load('../xml/pricelist.xml');
            $root = $dom->documentElement;
            $children = $root->childNodes;
            
            if( $children->length >= 3 ) {
                $remove_child_1 = $root->childNodes[ $children->length - 2];
                $remove_child_2 = $root->childNodes[ $children->length - 3];

                $root->removeChild( $remove_child_1 );
                $root->removeChild( $remove_child_2 );

                $res = $dom->save( '../xml/pricelist.xml' );
                
                if( !$res )
                    $warning .= "Не удалось удалить пункт. <br>";
            }else{
                $warning.= "Нечего удалять! <br>";
            }
        }
        
        if( $_POST['editCooperation'] == 'priceListNew' ){
            $dom = new DomDocument();
            $dom ->load('../xml/pricelist.xml');
            $root = $dom->documentElement; 
            
            $children = $root->childNodes;
            
            $new_node_1 = $root->childNodes[ $children->length - 3];
            $new_node_1 = $new_node_1->cloneNode( true );
            
            $new_node_2 = $root->childNodes[ $children->length - 2];
            $new_node_2 = $new_node_2->cloneNode( true );
            
            foreach( $new_node_2->childNodes as $elem ){
                if( $elem->nodeName == 'title' ){
                    $elem->removeChild($elem->childNodes[0]);
                    
                    $text = $dom->createTextNode('Новый статус.');
                    $elem->appendChild($text);
                }
                
                if( $elem->nodeName == 'price' ){
                    $elem->removeChild($elem->childNodes[0]);
                    
                    $text = $dom->createTextNode('Цена');
                    $elem->appendChild($text);
                }
                
                if( $elem->nodeName == 'id' ){
                    $node_id = $elem->childNodes[0]->data;
                    $node_id++;
                    
                    $elem->removeChild($elem->childNodes[0]);
                    
                    $text = $dom->createTextNode("$node_id");
                    $elem->appendChild($text);
                }
            }
            
            $root->insertBefore( $new_node_1, $root->childNodes[ $children->length - 1] );
            $root->insertBefore( $new_node_2, $root->childNodes[ $children->length - 1] );
            
            $res = $dom->save( '../xml/pricelist.xml' );
            
            if( !$res )
                $warning .= "Добавить новый пункт. <br>";
        }
        
        header("refresh:1;url=cabinet.php?editPage=cooperation");
    }
    
}
echo "<h1 style='color: red;'>$warning</h1>";
