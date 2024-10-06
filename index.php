<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Главная</title>
</head>
<script src="https://captcha-api.yandex.ru/captcha.js"></script>
<body>
<header>
    <li><a href="index.php">Логин</a></li>
    <li><a href="register.php">Регистрация</a></li>
    <li><a href="profile.php">Профиль</a></li>
    <li><a href="logout.php">Выход</a></li>
</header>
<br>
<h1>Главная</h1>
<form method="POST" action="">
    Телефон или Email: <input type="text" name="login" required><br>
    <br>
    Пароль: <input type="password" name="password" required><br>
    <div class="captcha-container">
        <div id="smart-captcha"></div>
    </div>
    <br>
    <input type="submit" value="Войти">
</form>
</body>
</html>

<?php
require 'funcs.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (loginUser($login, $password)) {
        header("Location: profile.php");
        exit;
    } else {
        $error = "Неверный логин или пароль.";
    }
}
if (isset($error)) {
    echo $error;
}

?>