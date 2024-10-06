<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
</head>
<body>
<header>
    <li><a href="index.php">Логин</a></li>
    <li><a href="register.php">Регистрация</a></li>
    <li><a href="profile.php">Профиль</a></li>
    <li><a href="logout.php">Выход</a></li>
</header>
<br>
<h1>Регистрация</h1>
<form method="POST">
    Имя: <input type="text" name="name" required><br><br>
    Телефон: <input type="text" name="phone" required><br><br>
    Почта: <input type="email" name="email" required><br><br>
    Пароль: <input type="password" name="password" required><br><br>
    Повторите пароль: <input type="password" name="confirm_password" required><br><br>
    <input type="submit" value="Зарегистрироваться"><br>
</form>
</body>
</html>
<?php
require 'funcs.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (userExists($email, $phone)) {
        $error = "Пользователь с таким телефоном или почтой уже существует.";
    }
    elseif ($password !== $confirm_password) {
        $error = "Пароли не совпадают.";
    }
    else {
        if (registerUser($name, $phone, $email, $password)) {
            header("Location: profile.php");
            exit;
        } else {
            $error = "Ошибка регистрации.";
        }
    }
}

if (isset($error)) {
    echo $error;
}