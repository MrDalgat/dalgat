<?php
session_start();
if ($_SESSION) {
    header("Location: profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="./php/login.php" method="post">
        <input type="text" name="login" placeholder="Введите ваш логин" required>
        <input type="password" name="password" placeholder="Введите ваш пароль" required>
        <button type="submit">Войти</button>
        <p>Нет аккаунта? <a href="register_form.php">Зарегистрироваться</a></p>
    </form>
</body>
</html>