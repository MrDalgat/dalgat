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
                <input type="tel" name="phone" id="phone" required>
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

    <script>
    function validateForm() {
        const login = document.getElementById('login').value;
        const password = document.getElementById('password').value;
        const fullname = document.getElementById('fullname').value;
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        const error = document.getElementById('error');

        if (!/^[А-Яа-яЁё]{6,}$/.test(login)) {
            error.textContent = 'Логин должен содержать минимум 6 символов кириллицы';
            return false;
        }

        if (password.length < 6) {
            error.textContent = 'Пароль должен содержать минимум 6 символов';
            return false;
        }

        if (!/^[А-Яа-яЁё\s]+$/.test(fullname)) {
            error.textContent = 'ФИО должно содержать только кириллицу и пробелы';
            return false;
        }

        if (!/^\d{10,15}$/.test(phone.replace(/\D/g, ''))) {
            error.textContent = 'Номер телефона должен содержать от 10 до 15 цифр';
            return false;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            error.textContent = 'Введите корректный email адрес';
            return false;
        }

        return true;
    }
    </script>
</body>
</html>
