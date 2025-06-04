<?php
session_start();

if(($_SESSION)){
    header('Location: profile.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
<form action="./php/register.php" method="post">
<input type="text" name="login" placeholder="Логин" required>
<input type="password" name="password" placeholder="Пароль" required>
<input type="password" name="repeatpassword" placeholder="Повторите пароль" required>
<input type="email" name="email" placeholder="email" required>
<button type="submit">Зарегистрироваться</button>
<a href="login_form.php">Войти если есть аккаунт</a>
</form>
</body>
</html>