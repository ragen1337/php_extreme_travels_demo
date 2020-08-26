<?php
    require_once "inc/authorisationValidation.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <div id="authorisationWindow">
        <h1>Авторизация:</h1>
        <strong style="color:<?=$color_msg?>;"><?=$message?></strong>
        <form action="" method="post">
            <h4>Логин:</h4>
            <input type="text" name="login" value="<?=$_POST[login]?>" required><br>
            <h4>Пароль:</h4>
            <input type="password" name="pwd" required><br>
            <input type="submit" id="submit2" value="Войти"><br>
        </form>
        <a href="index.php" id="back">На главную</a>
        <a href="registration.php" id="registration">Регистрация</a>
    </div>
</body>
</html>