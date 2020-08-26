<?php
$access_to_tour = 0;
        
if( $_GET['editTour'] == 'new' ){
        $query = "INSERT INTO tours (name, status, owner)
                    VALUES ('Новый тур', 'disabled', $quoted_person_login)";

        $pdo_obj = $pdo->exec( $query );
        $new_tour_id = $pdo->lastInsertId($pdo_obj);

        mkdir( "../img/tours/$new_tour_id" );
        copy( "../img/no_photo.jpg", "../img/tours/$new_tour_id/main.jpg" );

        header("refresh:1;url=cabinet.php?editTour=$new_tour_id");
    }

foreach( $tours_obj as $tour ){
    if( $_GET['editTour'] == $tour['id']){
        $access_to_tour = 1;
    }
    $tours_array[ $tour['id'] ]['name'] = $tour['name'];
    $tours_array[ $tour['id'] ]['description'] = $tour['description'];
    $tours_array[ $tour['id'] ]['terms'] = $tour['terms'];
    $tours_array[ $tour['id'] ]['kindOfSport'] = $tour['kindOfSport'];
    $tours_array[ $tour['id'] ]['freePlaces'] = $tour['freePlaces'];
    $tours_array[ $tour['id'] ]['dateFrom'] = $tour['dateFrom'];
    $tours_array[ $tour['id'] ]['dateTo'] = $tour['dateTo'];
    $tours_array[ $tour['id'] ]['country'] = $tour['country'];
    $tours_array[ $tour['id'] ]['city'] = $tour['city'];
    $tours_array[ $tour['id'] ]['price'] = $tour['price'];
    $tours_array[ $tour['id'] ]['owner'] = $tour['owner'];
    $tours_array[ $tour['id'] ]['status'] = $tour['status'];
    $i++;
}

if( $access_to_tour ){
    $editContentHeader = "Тур#" . $_GET['editTour'];
    $day_today = date('Y-m-d' ,time() );

    $photos_directory_array = scandir("../img/tours/" . $_GET['editTour']);

    $draw_photo_string = null;
    foreach( $photos_directory_array as $photo ){
        if($photo == '.' || $photo == '..' || $photo == 'main.jpg' ){
            continue;
        }else{
            $draw_photo_string .= "
            <div class='deletePhotoSingleBlock'>
                <img src='../img/tours/{$_GET[ 'editTour' ]}/$photo' alt='photo' height='300' width='400'>
                <div class='deletePhotoSingleBlockCheckBox'>
                    <input type='checkbox' name='deletePhotos[]' value='$photo' style='cursor:pointer;transform:scale(10);'>
                </div>
            </div>";
        }
    }
    $content = "<form action='toursEditorDB.php' method='post'>
                    <div id='changeTourInfoBlock1'>
                        <h4>Название тура:</h4>
                        <input type='text' name='changeName' value='{$tours_array[ $_GET[ 'editTour'] ]['name']}' required>
                        <h4>Дата начала тура:</h4>
                        <input type='date' name='changeDateFrom' min='$day_today' value='{$tours_array[ $_GET[ 'editTour'] ]['dateFrom']}' required>
                        <h4>Страна:</h4>
                        <input type='text' name='changeCountry' value='{$tours_array[ $_GET[ 'editTour'] ]['country']}' required>
                        <h4>Цена за человека:</h4>
                        <input type='number' name='changePrice' value='{$tours_array[ $_GET[ 'editTour'] ]['price']}' required>
                        <h4>Статус:</h4>";
                        if( $tours_array[ $_GET[ 'editTour'] ]['status'] == 'active'){
                            $content.=" <select name='changeStatus'>
                                            <option selected>active</option>
                                            <option>disabled</option>
                            ";     
                        }else{
                            $content.=" <select name='changeStatus'>
                                            <option>active</option>
                                            <option selected>disabled</option>
                            ";     
                        }
                        $content.= "    
                        </select> 
                    </div>
                    <div id='changeTourInfoBlock2'>
                        <h4>Вид спорта:</h4>
                        <input type='text' name='changeKindOfSport' value='{$tours_array[ $_GET[ 'editTour'] ]['kindOfSport']}' required>
                        <h4>Дата окончания тура:</h4>
                        <input type='date' name='changeDateTo' min='$day_today' value='{$tours_array[ $_GET[ 'editTour'] ]['dateTo']}' required>
                        <h4>Город:</h4>
                        <input type='text' name='changeCity' value='{$tours_array[ $_GET[ 'editTour'] ]['city']}' required>
                        <h4>Свободные места:</h4>
                        <input type='number' name='changeFreePlaces' value='{$tours_array[ $_GET[ 'editTour'] ]['freePlaces']}' required>
                    </div>
                    <div id='changeTourInfoBlock3'>
                        <h3>Описание:</h3>
                        <textarea rows='10' name='changeDescription' wrap='soft' required>{$tours_array[ $_GET[ 'editTour'] ]['description']}</textarea>
                        <h3>Условия:</h3>
                        <textarea rows='10' name='changeTerms' wrap='soft' required>{$tours_array[ $_GET[ 'editTour'] ]['terms']}</textarea>
                        <input type='hidden' name='changeType' value='mainInfo'>
                        <input type='hidden' name='tourId' value='{$_GET[ 'editTour' ]}'>
                        <input type='submit' id='acceptMainInfoChanges' value='Принять изменения'>
                        <input type='reset' id='resetMainInfoChanges' value='Сбросить'>
                    </div>
                </form>
                <div id='mainImageForm'>
                    <form action='toursEditorDB.php' method='post' enctype='multipart/form-data'>
                        <section>
                            <h3>Изменить заглавное изображение:</h3>
                            <img src='../img/tours/{$_GET['editTour']}/main.jpg' alt='main_image' height='300' width='400'>
                            <div id='uploadMainImage'>
                                <input type='file' name='mainPhotoFile' accept='image/jpeg'>
                                <strong class='fileUploadWarning'>Максимальный вес: 5МБ<br>Файл может быть только изображением JPEG).</strong>
                            </div>
                            <input type='hidden' name='changeType' value='mainPhoto'>
                            <input type='hidden' name='tourId' value='{$_GET[ 'editTour' ]}'>
                            <input type='submit' id='acceptMainPhotoChanges' value='Изменить'>
                        </section>
                    </form>
                </div>
                <div id='deletePhotosForm'>
                    <form action='toursEditorDB.php' method='post'>
                        <section>
                            <h3>Удалить фотографии:</h3>
                            <div id='deletePhotosBlock'>$draw_photo_string</div>
                            <input type='hidden' name='changeType' value='deletePhotos'>
                            <input type='hidden' name='tourId' value='{$_GET[ 'editTour' ]}'>
                            <strong class='fileUploadWarning'>Выберите изображения, которые хотите удалить.</strong>
                            <input type='submit' id='acceptDeletePhotos' value='Удалить'>
                        </section>
                    </form>
                </div>
                <div id='uploadPhotosForm'>
                    <form action='toursEditorDB.php' method='post' enctype='multipart/form-data'>
                        <h3>Добавить фотографии:</h3>
                        <div id='uploadPhotosFormBlock'>
                            <input type='file' name='photoCollage[]' accept='image/jpeg' multiple>
                            <strong class='fileUploadWarning'>Максимальный вес файла: 5МБ<br>Файл может быть только изображением JPEG).</strong>
                        </div>
                        <input type='hidden' name='changeType' value='uploadPhotos'>
                        <input type='hidden' name='tourId' value='{$_GET[ 'editTour' ]}'>
                        <input type='submit' id='acceptUploadPhotos' value='Добавить фотографии'>
                    </form>
                </div>
                <div id='deleteTourBlock'>
                    <form action='toursEditorDB.php' method='post'>
                        <input type='hidden' name='tourId' value='{$_GET[ 'editTour' ]}'>
                        <input type='hidden' name='changeType' value='deleteTour'>
                        <input type='submit' id='deleteTourSubmit' value='Удалить тур'>
                    </form>
                </div>";

    $bottomBar="<div id='cabinetBottomBar'>
                    <a href='cabinet.php' id='backToListOfTours'>Вернуться</a>
                    <a href='../?tour={$_GET[ 'editTour' ]}' id='toPage' target='_blank'>Перейти на страницу тура</a>
                </div>";

    $allBlocksHeight = "2167px";
}elseif( !$access_to_tour && ( $_GET[ 'editTour'] != 'new' ) ){
    $content = "<img src='../img/oops.jpg' alt='У вас нед доступа к этой странице' id='oopsImg'>";
    $editContentHeader = "У вас нет доступа к этой странице!";
    $allBlocksHeight = "497px";
}