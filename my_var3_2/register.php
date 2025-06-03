<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Регистрация - Грузовозофф</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <h1>Регистрация в системе</h1>
        <form action="save_register.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label>Логин (минимум 6 символов):</label>
                <input type="text" name="login" id="login" pattern="[А-Яа-яЁё]{6,}" required>
            </div>
            <div class="form-group">
                <label>Пароль (минимум 6 символов):</label>
                <input type="password" name="password" id="password" minlength="6" required>
            </div>
            <div class="form-group">
                <label>ФИО:</label>
                <input type="text" name="fullname" id="fullname" pattern="[А-Яа-яЁё\s]+" required>
            </div>
            <div class="form-group">
                <label>Телефон:</label>
                <input type="tel" name="phone" id="phone" placeholder="+7(999)-999-99-99" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div id="error" class="error"></div>
            <button type="submit">Зарегистрироваться</button>
        </form>
        <div class="nav">
            <a href="index.php">Вернуться на главную</a>
        </div>
    </div>
        
    <script src="register.js"></script>
</body>
</html>