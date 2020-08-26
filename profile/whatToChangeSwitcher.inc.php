<?php
if( $access == "AGENCY"){
    $quoted_person_login = $pdo->quote( $person_login );
    $query = "SELECT * FROM tours
                WHERE owner=$quoted_person_login
                AND NOT status='deleted'
                ORDER BY status";

    $tours_obj = $pdo->query( $query );

    if( !$_GET['editTour'] ){
        $editContentHeader = "Редактор туров";
        $content = "<section id='editTours'>
                        <h2>Редактировать объявления</h2>
                        <ul>";

        foreach( $tours_obj as $tour ){
            $content.= "<li><a href='?editTour={$tour['id']}'>{$tour['name']}</a><span class='tourStatus'>({$tour['status']})</span></li>";
        }

        $content.= "        <li><a href='?editTour=new' style='text-decoration:none;font-weight:bold;color:blue;'>Добавить новый тур</a></li>
                        </ul>
                    </section>";

        $bottomBar="<div id='cabinetBottomBar'>
                        <a href='profile.php' id='backToListOfTours'>Вернуться</a>
                    </div>";

        $allBlocksHeight = "432px";
    }
}else{
    $quoted_person_login = $pdo->quote( $person_login );
    $query = "SELECT * FROM tours
                WHERE NOT status='deleted'
                ORDER BY status";

    $tours_obj = $pdo->query( $query );

    if( !$_GET['editTour'] && !$_GET['editPage']){
        $editContentHeader = "Редактор туров и страниц";
        $content = "<section id='editTours'>
                        <h2>Редактировать объявления<span id='tourOwnerHeader'>Владелец</span></h2>
                        <ul>";
                            foreach( $tours_obj as $tour ){
                                $content.= "<li><a href='?editTour={$tour['id']}'>{$tour['name']}</a>
                                <span class='tourStatus'>({$tour['status']})</span>
                                <span class='tourOwner'>{$tour['owner']}</span></li>";
                            }
        $content.= "        <li><a href='?editTour=new' style='text-decoration:none;font-weight:bold;color:blue;'>Добавить новый тур</a></li>
                        </ul>
                    </section>
                    <section id='editPages'>
                        <h2>Редактировать страницы</h2>
                        <ul>
                            <li><a href='?editPage=profiles'>Профили</a></li>
                            <li><a href='?editPage=header'>Шапка</a></li>
                            <li><a href='?editPage=main'>Главная</a></li>
                            <li><a href='?editPage=commonInfo'>Общая информация</a></li>
                            <li><a href='?editPage=cooperation'>Начало сотрудничества</a></li>
                            <li><a href='?editPage=contacts'>Контакты</a></li>
                            <li><a href='?editPage=faq'>Вопросы и ответы</a></li>
                        </ul>
                    </section>
                    ";

        $bottomBar="<div id='cabinetBottomBar'>
                        <a href='profile.php' id='backToListOfTours'>Вернуться</a>
                    </div>";

        $allBlocksHeight = "794px";
    } 
}