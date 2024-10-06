<?php
session_start();

$host = 'localhost';
$db = 'auth';
$user = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к бд: " . $e->getMessage());
}
function userExists($email, $phone) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR phone = :phone");
    $stmt->execute(['email' => $email, 'phone' => $phone]);
    return $stmt->fetch();
}

function registerUser($name, $phone, $email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)");
    return $stmt->execute([
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
}

function loginUser($login, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :login OR phone = :login");
    $stmt->execute(['login' => $login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function updateUser($id, $name, $phone, $email, $password = null) {
    global $pdo;
    $query = "UPDATE users SET name = :name, phone = :phone, email = :email";

    if ($password) {
        $query .= ", password = :password";
    }

    $query .= " WHERE id = :id";

    $stmt = $pdo->prepare($query);

    $data = ['name' => $name, 'phone' => $phone, 'email' => $email, 'id' => $id];

    if ($password) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    return $stmt->execute($data);
}

