<?php
require_once "profileVisitorIdentification.inc.php";

if( $access == "DENIED" ){
    $welcome = "<h2 id='profilePageWelcome' style='color:firebrick;'>Зарегистрируйтесь, чтоб иметь доступ к личному кабинету!</h2>";
    $content = "<img src='../img/oops.jpg' alt='У вас нед доступа к этой странице' id='oopsImg'>";
}else{
    if( $_GET[page] != "edit"){
        if( $access == "ADMIN" ){
            $cabinetPanel = "<a id='profileCabinetPanel' href='cabinet.php'>Админка</a>";
        }elseif( $access == "AGENCY" ){
            $cabinetPanel = "<a id='profileCabinetPanel' href='cabinet.php'>Редактировать объявления</a>";
        }
        $welcome = "<h2 id='profilePageWelcome'>Добро пожаловать в личный кабинет, $person_name !</h2>";
        $back = "<a id='profileBack' href='../index.php'>Вернуться</a>";
        $content = "
            <div id='leftColumn'>
                <span class='leftColumnSpan'>Логин: <span class='infoSpan'>$person_login</span></span>
                <span class='leftColumnSpan'>Имя: <span class='infoSpan'>$person_name</span></span>
                <span class='leftColumnSpan'>Дата рождения: <span class='infoSpan'>$person_birth_date</span></span>
                <span class='leftColumnSpan'>Страна: <span class='infoSpan'>$person_country</span></span>
            </div>
            <div id='rightColumn'>
                <span class='rightColumnSpan'>Email: <span class='infoSpan'>$person_email</span></span>
                <span class='rightColumnSpan'>Фамилия: <span class='infoSpan'>$person_surname</span></span>
                <span class='rightColumnSpan'>Номер: <span class='infoSpan'>$person_phone_number</span></span>
                <span class='rightColumnSpan' >Город: <span class='infoSpan'>$person_city</span></span>
            </div>
            <div id='edit'>
                <a href='?page=edit' id='editProfileHref'>Редактировать</a>
            </div>
            ";
        }else{
            if( $access == "ADMIN" ){
                $cabinetPanel = "<a id='profileCabinetPanelEdit' href='cabinet.php'>Админка</a>";
            }elseif( $access == "AGENCY" ){
                $cabinetPanel = "<a id='profileCabinetPanelEdit' href='cabinet.php'>Редактировать объявления</a>";
            }
            $welcome = "<h2 id='profilePageWelcome'>$person_name, внесите изменения в профиль.</h2>";
            $back = "<a id='profileBackEdit' href='profile.php'>Вернуться</a>";
            $content = "
                <form action='' method='post'>
                    <div id='leftEditColumn'>
                        <span class='leftColumnSpanEdit'>Email: <input type='email' name='email' value='$person_email' class='editInput'></span>
                        <span class='leftColumnSpanEdit'>Имя: <input type='text' name='name' value='$person_name' class='editInput'></span>
                        <span class='leftColumnSpanEdit'>Страна: <input type='text' name='country' value='$person_country' class='editInput'></span>
                        <span class='leftColumnSpanEdit'>Номер: <input type='tel' name='phoneNumber' value='$person_phone_number' class='editInput'></span>
                    </div>
                    <div id='rightEditColumn'>
                        <span class='rightColumnSpanEdit'>Дата рождения: <input type='date' name='birthDate' value='$person_birth_date' id='birthDateEdit' class='editInput' min='1920-01-01' max='2020-01-01'></span>
                        <span class='rightColumnSpanEdit'>Фамилия: <input type='text' name='surname' value='$person_surname' class='editInput'></span>
                        <span class='rightColumnSpanEdit'>Город: <input type='text' name='city' value='$person_city' class='editInput'></span>
                        <input type='hidden' name='mainInfoHidden' value='main'>
                    </div>
                    <input type='submit' value='Изменить' id='profileMainInfoEditSubmit'>
                </form>
                <div id='pwdEditBlock'>
                    <h4 id='changePwdHeader'>Смена пароля:</h4>
                    <form action='' method='post'>
                        <div id='changePwdInputsBlock'>
                            <section>
                                <h5>Старый пароль</h5>
                                <input type='password' name='oldPwd' class='editPwd'>
                            </section>
                            <section>
                                <h5>Новый пароль</h5>
                                <input type='password' name='newPwd1' class='editPwd'>
                            </section>
                            <section>
                                <h5>Повторите новый пароль</h5>
                                <input type='password' name='newPwd2' class='editPwd'>
                            </section>
                            <section>
                                <input type='submit' id='submitPwd' value='Изменить'>
                            </section>
                            <input type='hidden' name='pwdHidden' value='pwd'>
                        </div>
                    </form>
                </div>
            ";
        }
}