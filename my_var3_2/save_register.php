<?php
session_start();
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Проверка на существующий логин
    $check = $conn->prepare("SELECT id FROM users WHERE login = ?");
    $check->bind_param("s", $login);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Пользователь с таким логином уже существует";
        header("Location: register.php");
        exit();
    }

    // Добавление нового пользователя
    $stmt = $conn->prepare("INSERT INTO users (login, password, fullname, phone, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $login, $password, $fullname, $phone, $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Регистрация успешна! Теперь вы можете войти.";
        header("Location: index.php");
    } else {
        $_SESSION['error'] = "Ошибка при регистрации: " . $conn->error;
        header("Location: register.php");
    }
    exit();
}
?>
