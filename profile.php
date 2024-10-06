<?php
require 'funcs.php';

if (!isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$user = getUserById($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Пароли не совпадают.";
    } else {
        if (updateUser($user['id'], $name, $phone, $email, $password)) {
            $succes = "Данные обновлены.";
        } else {
            $error = "Ошибка обновления.";
        }
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Профиль</title>
</head>
<body>
<header>
    <li><a href="index.php">Логин</a></li>
    <li><a href="register.php">Регистрация</a></li>
    <li><a href="profile.php">Профиль</a></li>
    <li><a href="logout.php">Выход</a></li>
</header>
<h1>Профиль</h1>
<form method="POST" action="">
    Имя: <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br><br>
    Телефон: <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required><br><br>
    Почта: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>
    Новый пароль: <input type="password" name="password"><br><br>
    Повторите новый пароль: <input type="password" name="confirm_password"><br><br>
    <input type="submit" value="Обновить"><br><br>
</form>
</body>
</html>
<?php
if (isset($error)) {
    echo $error;
}
if (isset($succes)) {
    echo $succes;
}
?>
