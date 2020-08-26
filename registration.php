<?php
    require_once "inc/registrationValidation.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <div id="registrationWindow">
        <h1>Регистрация:</h1>
        <strong style="color:<?=$color_msg?>;"><?=$message?></strong>
        <form action="" method="post">
            <h4>Имя:</h4>
            <input type="text" name="name" value="<?=$_POST[name]?>" required><br>
            <h4>Фамилия:</h4>
            <input type="text" name="surname" value="<?=$_POST[surname]?>" required><br>
            <h4>Дата рождения:</h4>
            <input type="date" name="birthDate" id="birthDate" min="1920-01-01" max="2020-01-01" value="<?=$_POST[birthDate]?>" required><br>
            <h4>Страна:</h4>
            <input type="text" name="country" value="<?=$_POST[country]?>" required><br>
            <h4>Город:</h4>
            <input type="text" name="city" value="<?=$_POST[city]?>" required><br>
            <h4>Номер телефона:</h4>
            <input type="tel" name="phoneNumber" value="<?=$_POST[phoneNumber]?>" required><br>
            <h4>Ваш email:</h4>
            <input type="email" name="email" value="<?=$_POST[email]?>" required><br>
            <h4>Логин:</h4>
            <input type="text" name="login" value="<?=$_POST[login]?>" required><br>
            <h4>Пароль:</h4>
            <input type="password" name="pwd1" value="<?=$_POST[pwd1]?>" required><br>
            <h4>Повторите пароль:</h4>
            <input type="password" name="pwd2" required><br>
            <input type="submit" id="submit" value="Регистрация"><br>
        </form>
        <a href="index.php" id="back">На главную</a>
        <a href="authorisation.php" id="authorisation">Авторизация</a>
    </div>
</body>
</html>