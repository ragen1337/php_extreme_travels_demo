<?php
$bottomBar="<div id='cabinetEditPagesBottomBar'>
                    <a href='cabinet.php' id='backToAdminCabinet'>Вернуться</a>";

if( $_GET['editPage'] == 'profiles' ){
    
}

if( $_GET['editPage'] == 'header' ){
    $query = "SELECT content FROM content
                WHERE html_id = 'headerInfo'";
    $header_info_obj = $pdo->query( $query );
    
    foreach( $header_info_obj as $elem){
        $header_info = $elem['content'];
    }
    
    $editContentHeader = "Редактирование шапки сайта";
    $content = "
                <section id='changeHeaderImage'>
                    <h3>Изменить изображение в шапке:</h3>
                    <img src='../img/headerImg.jpg' alt='photo' width='600' height='90'>
                    <form method='post' enctype='multipart/form-data' action='toursEditorDB.php'>
                        <input type='file' accept='image/jpeg' name='headerImageFile'>
                        <input type='hidden' name='editHeader' value='headerImage'>
                        <div id='changeHeaderImgSubmit'>
                            <input type='submit' value='Изменить'>
                        </div>
                    </form>
                </section>
                <section id='changeLogoImage'>
                    <h3>Изменить Лого:</h3>
                    <img src='../img/logo.png' alt='photo' width='110' height='110'>
                    <form method='post' enctype='multipart/form-data' action='toursEditorDB.php'>
                        <input type='file' accept='image/png' name='headerLogoFile'>
                        <input type='hidden' name='editHeader' value='logoImage'>
                        <div id='changeHeaderLogoSubmit'>
                            <input type='submit' value='Изменить'>
                        </div>
                    </form>
                </section>
                <section id='changeHeaderInfo'>
                    <h3>Изменить информацию в шапке:</h3>
                    <form method='post' action='toursEditorDB.php'>
                        <textarea name='headerInfoText' wrap='soft' id='headerInfoText'>$header_info</textarea>
                        <input type='hidden' name='editHeader' value='headerInfo'>
                        <div id='headerInfoSubmit'>
                            <input type='submit' value='Изменить'>
                        </div>
                    </form>
                </section>
    ";
    
    $bottomBar .= "
        <a href='../index.php' id='checkPageChanges' target='_blank'>Посмотреть страницу</a>
    ";
    
    $allBlocksHeight = "640px";
}

if( $_GET['editPage'] == 'main' ){
    $query = "SELECT * FROM content
                WHERE module='main.inc.php'
                ORDER BY common_block";
    $main_page_content_obj = $pdo->query( $query );
    
    $i = 0;
    $j = 0;
    $k = 0;
    $a = 0;
    foreach( $main_page_content_obj as $page_elem ){
        if( stristr( $page_elem['common_block'], 'tourTypes' ) ){
            if( stristr( $page_elem['html_id'], 'tourTypesHeader' ) ){
                $main_page_blocks_headers[$i]['name'] = $page_elem['content'];
                $main_page_blocks_headers[$i]['href'] = $page_elem['href'];
                $i++;
            }
            
            if( stristr( $page_elem['html_id'], 'tourTypesDescription' ) ){
                $main_page_blocks_descriptions[$j] = $page_elem['content'];
                $j++;
            }
        }
        
        if( stristr( $page_elem['common_block'], 'mainPageBottomBarElem' ) ){
            if( stristr( $page_elem['html_id'], 'mainPageBottomBarElemHref' ) ){
                $main_page_bottom_bar_hrefs[$k] = $page_elem['href'];
                $k++;
            }
            
            if( stristr( $page_elem['html_id'], 'mainPageBottomBarElemHeader' ) ){
                $main_page_bottom_bar_headers[$a] = $page_elem['content'];
                $a++;
            }
        }
        
        if( $page_elem['html_id'] == 'mainPageBottomBarHeader'){
            $main_page_bottom_bar_main_header = $page_elem['content'];
        }
        
        if( $page_elem['html_id'] == 'mainAdvertisingHref'){
            $main_advertising_href = $page_elem['href'];
        }
        
    }
    
    $editContentHeader = "Редактирование главной страницы.";
    
    foreach( $main_page_blocks_headers as $key => $header ){
        $num = $key + 1;
        $content.= "
            <section id='changeMainPageBlock$num' class='changeMainPageBlock'>
                <h3>Блок $num:</h3>
                <form method='post' action='toursEditorDB.php' class='blockInfoForm'>
                    <h3>Заголовок:</h3>
                    <textarea name='changeMainPageHeader$num' id='changeMainPageHeader$num' class='changeMainPageHeader' wrap='soft'>{$header['name']}</textarea>
                    <h3>Ссылка заголовка:</h3>
                    <textarea name='changeMainPageHeaderHref$num' id='changeMainPageHeaderHref$num' class='changeMainPageHeaderHref' wrap='soft'>{$header['href']}</textarea>
                    <h3>Описание:</h3>
                    <textarea name='changeMainPageDescription$num' id='changeMainPageDescription$num' class='changeMainPageDescription' wrap='soft'>{$main_page_blocks_descriptions[$key]}</textarea>
                    <input type='hidden' name='editMainPage' value='blocksInfo'>
                    <input type='hidden' name='blockNumber' value='$num'>
                    <input type='submit' value='Изменить'>
                </form>
                <form method='post' enctype='multipart/form-data' action='toursEditorDB.php' class='blockImgForm'>
                    <h3>Изменить фотографии:</h3>";
                    for( $i = 1; $i <= 3; $i++ ){
                        $content .= "
                        <div class='changeMainPageBlockImgDiv'>
                            <img src='../img/tourTypesImage{$num}_{$i}.jpg' alt='photo' width='250' height='250'>
                            <input type='file' name='tourTypesImage{$num}_{$i}'>
                        </div>";
                    }
    $content .="    <input type='hidden' name='blockNumber' value='$num'>
                    <input type='hidden' name='editMainPage' value='blocksImages'>
                    <input type='submit' value='Изменить' class='blockImgFormSubmit'>
                </form>
            </section>
        ";
    }
    $content .= "
        <section id='changeMainPageBottomBar'>
            <h3>Нижнее меню:</h3>
            <form method='post' enctype='multipart/form-data' action='toursEditorDB.php' name='editMainPage' value='changeBottomBar'>
                <h3>Главный заголовок:</h3>
                <textarea name='mainPageBottomBarHeader' id='changeMainPageBottomBarHeader' wrap='soft'>$main_page_bottom_bar_main_header</textarea>
                <h3>Изображения, заголовки и ссылки</h3>";
            foreach( $main_page_bottom_bar_headers as $key => $header ){
                $num = $key + 1;
                $content .="
                <div class='mainPageBottomBarBlockChange'>
                    <img src='../img/mainPageBottomBarImg$num.jpg' alt='photo' width='250' height='250'>
                    <h4>Заголовок:</h4>
                    <textarea name='mainPageBottomBarElemHeader$num' class='changeMainPageBottomBarBlockHeader' wrap='soft'>$header</textarea>
                    <h4>Ссылка:</h4>
                    <textarea name='mainPageBottomBarElemHref$num' class='changeMainPageBottomBarHref' wrap='soft'>{$main_page_bottom_bar_hrefs[$key]}</textarea>
                    <input type='file' name='mainPageBottomBarImg$num'>
                </div>";
            }
    $content .="
            <input type='hidden' name='editMainPage' value='bottomBar'>
            <input type='submit' value='Изменить' id='bottomBarSubmitChanges'>
            </form>
        </section>
        <section id='changeMainPageAdvertising'>
            <h3>Реклама:</h3>
            <form method='post' enctype='multipart/form-data' action='toursEditorDB.php' name='editMainPage' value='changeAdvertisingImage'>
                <img src='../img/mainAdvertising.jpg' alt='photo' width='100' height='450'>
                <h4>Ссылка на ресурс:</h4>
                <textarea name='mainAdvertisingHref' id='mainAdvertisingHref' wrap='soft'>$main_advertising_href</textarea>
                <input type='file' name='mainAdvertising' id='mainAdvertisingImgFile'>
                <input type='hidden' name='editMainPage' value='advertising'>
                <input type='submit' id='mainAdvertisingSubmit'>
            </form>
        </section>
    ";
    
    $bottomBar .= "
        <a href='../index.php' id='checkPageChanges' target='_blank'>Посмотреть страницу</a>
    ";
    
    $allBlocksHeight = "6530px";
}

if( $_GET['editPage'] == 'commonInfo' ){
    $query = "SELECT html_id, content FROM content
            WHERE module='commonInfo.inc.php' ORDER BY html_id";
    $common_info_obj = $pdo->query( $query );
    
    $i = 0;
    $j = 0;
    foreach( $common_info_obj as $elem ){
        if( stristr( $elem['html_id'] , 'commonInfoHeader' )  ){
            $common_info_headers[$i] = $elem['content'];
            $i++;
        }

        if( stristr( $elem['html_id'] , 'commonInfoArticle' )  ){
            $common_info_articles[$j] = $elem['content'];
            $j++;
        }
    }
    
    $editContentHeader = "Редактирование страницы 'Общая информация'.";
    
    $content .= "<div id='commonInfoForm'>
                    <form method='post' action='toursEditorDB.php'>";
    foreach ( $common_info_headers as $key => $header ){
        $num = $key + 1;
        
        $content.="
            <section id='commonInfoBlock$num' class='commonInfoBlock'>
                <h3>Блок $num</h3>
                <h4>Заголовок:</h4>
                <textarea name='commonInfoHeader$num' class='commonInfoHeader' wrap='soft'>$header</textarea>
                <h4>Текст:</h4>
                <textarea name='commonInfoArticle$num' class='commonInfoArticle' wrap='soft'>{$common_info_articles[$key]}</textarea>
            </section>";
    }
    $content .= "       <input type='hidden' name='editCommonInfo' value='all'>
                        <input type='submit' id='commonInfoEditSubmit' value='Изменить'>
                    </form>
                </div>";
    
    $bottomBar .= "
        <a href='../index.php?page=commonInfo' id='checkPageChanges' target='_blank'>Посмотреть страницу</a>
    ";
    
    $allBlocksHeight = "1030px";
}

if( $_GET['editPage'] == 'cooperation' ){
    $query = "SELECT html_id, content FROM content
                WHERE module='cooperation.inc.php' ORDER BY html_id";
    $content_obj = $pdo->query( $query );

    $i = 0;
    $j = 0;
    foreach( $content_obj as $elem ){
        if( stristr( $elem['html_id'] , 'cooperationHeader' )  ){
            $cooperation_headers[$i] = $elem['content'];
            $i++;
        }

        if( stristr( $elem['html_id'] , 'cooperationArticle' )  ){
            $cooperation_articles[$j] = $elem['content'];
            $j++;
        }

        if( $elem['html_id'] == 'cooperationPageEmail' ){
            $cooperation_email = $elem['content'];
        }

        if( $elem['html_id'] == 'cooperationPagePhone' ){
            $cooperation_phone = $elem['content'];
        }
    }
    
    $sxml_pricelist_obj = simplexml_load_file('../xml/pricelist.xml');
    
    foreach( $sxml_pricelist_obj as $elem ){
        $table_content .="<tr>
                            <form method='post' action='toursEditorDB.php'>
                                <input type='hidden' name='editCooperation' value='priceList'>
                                <td><input type='hidden' name='productId' value='$elem->id'>$elem->id</td>
                                <td><input type='text' name='productTitle' value='$elem->title' class='productTitle'></td>
                                <td><input type='text' name='productPrice' value='$elem->price' class='productPrice'></td>
                                <td><input type='submit' value='Изменить' class='changeProduct'></td>
                            </form>
                        </tr>";
    }
    
    $editContentHeader = "Редактирование страницы 'Начало сотрудничества'.";
    
    $content .= "<div id='cooperationMainInfoForm'>
                    <form method='post' action='toursEditorDB.php'>";
    foreach( $cooperation_headers as $key => $header ){
        $num = $key + 1;
        $content.="     <section>
                            <h3>Блок $num</h3>
                            <h4>Заголовок:</h4>
                            <textarea name='cooperationHeader$num' class='cooperationHeader' wrap='soft'>$header</textarea>
                            <h4>Текст:</h4>
                            <textarea name='cooperationArticle$num' class='cooperationArticle' wrap='soft'>{$cooperation_articles[$key]}</textarea>
                        </section>";
    }
    $content .= "       <section id='cooperationInfo'>
                            <h3>Контактная информация:</h3>
                            <h4>Поле 1:</h4>
                            <input type='text' name='cooperationPageEmail' value='$cooperation_email'>
                            <h4>Поле 2:<h4>
                            <input type='text' name='cooperationPagePhone' value='$cooperation_phone'>
                        </section>
                        <input type='hidden' name='editCooperation' value='mainInfo'>
                        <input type='submit' id='cooperationSubmit'>
                    </form>
                </div>
                <div id='cooperationEditPricelistForm'>
                    <section>
                        <h3>Изменить Pricelist</h3>
                        <div id='tableDiv'>
                            <table border='1'>
                                <tr>
                                    <th width='50'>ID</th>
                                    <th width='350'>Тип статуса</th>
                                    <th width='100'>Цена</th>
                                    <th width='100'></th>
                                </tr>
                                $table_content
                            </table>
                        </div>
                        <form method='post' action='toursEditorDB.php'>
                            <input type='hidden' name='editCooperation' value='priceListDeleteLast'>
                            <input type='submit' value='Удалить последний элемент' id='priceListDeleteLast'>
                        </form>
                        <form method='post' action='toursEditorDB.php'>
                            <input type='hidden' name='editCooperation' value='priceListNew'>
                            <input type='submit' value='Добавить новый элемент' id='priceListNew'>
                        </form>
                    </section>
                </div>
                ";
    
    $bottomBar .= "
        <a href='../index.php?page=cooperation' id='checkPageChanges' target='_blank'>Посмотреть страницу</a>
    ";
    
    $allBlocksHeight = "1040px";
}

if( $_GET['editPage'] == 'contacts' ){
    
}

$bottomBar .= "</div>";
