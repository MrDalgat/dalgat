//add_review.php
//admin_logout.php
//admin.php
//create_request.php
//db.php
//db.sql
//index.php
//login.php
//logout.php
//my_requests.php
//register.php
//save_register.php
//save_request.php
//style.css
//update_status.php


<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Грузовозофф - Вход в систему</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <h1>Грузовозофф</h1>
        <?php if(isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if(!isset($_SESSION['user_id'])): ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label>Логин:</label>
                    <input type="text" name="login" required>
                </div>
                <div class="form-group">
                    <label>Пароль:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Войти</button>
            </form>
            <div class="nav">
                <a href="register.php">Регистрация</a>
                <a href="admin.php">Панель администратора</a>
            </div>
        <?php else: ?>
            <div class="nav">
                <a href="create_request.php" class="button">Создать заявку</a>
                <a href="my_requests.php" class="button">Мои заявки</a>
                <a href="logout.php">Выйти</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
