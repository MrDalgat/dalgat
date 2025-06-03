<?php
session_start();
require_once('db.php');

// Проверка авторизации админа
if (!isset($_SESSION['admin'])) {
    if (isset($_POST['login']) && isset($_POST['password'])) {
        if ($_POST['login'] === 'admin' && $_POST['password'] === 'gruzovik2024') {
            $_SESSION['admin'] = true;
        } else {
            $_SESSION['error'] = "Неверный логин или пароль";
            header("Location: admin.php");
            exit();
        }
    } else {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Админ-панель - Грузовозофф</title>
            <link rel="stylesheet" href="style.css">
            <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body>
            <div class="container">
                <h1>Вход в панель администратора</h1>
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="form-group">
                        <label>Логин:</label>
                        <input type="text" name="login" required>
                    </div>
                    <div class="form-group">
                        <label>Пароль:</label>
                        <input type="password" name="password" required>
                    </div>
                    <button type="submit">Войти</button>
                    <div class="nav">
                        <a href="index.php">Войти как пользователь</a>
                    </div>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
}

// Получаем все заявки
$result = $conn->query("SELECT r.*, u.fullname, u.phone, u.email FROM requests r JOIN users u ON r.user_id = u.id ORDER BY r.date_time DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Админ-панель - Грузовозофф</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <h1>Панель администратора</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="request-list">
            <?php while($request = $result->fetch_assoc()): ?>
                <div class="request-item">
                    <p><strong>Заказчик:</strong> <?php echo htmlspecialchars($request['fullname']); ?></p>
                    <p><strong>Телефон:</strong> <?php echo htmlspecialchars($request['phone']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($request['email']); ?></p>
                    <p><strong>Дата и время:</strong> <?php echo $request['date_time']; ?></p>
                    <p><strong>Вес:</strong> <?php echo htmlspecialchars($request['weight']); ?> кг</p>
                    <p><strong>Габариты:</strong> <?php echo htmlspecialchars($request['dimensions']); ?></p>
                    <p><strong>Тип груза:</strong> <?php echo htmlspecialchars($request['cargo_type']); ?></p>
                    <p><strong>Откуда:</strong> <?php echo htmlspecialchars($request['from_address']); ?></p>
                    <p><strong>Куда:</strong> <?php echo htmlspecialchars($request['to_address']); ?></p>
                    <p><strong>Статус:</strong> <span class="status-<?php echo strtolower($request['status']); ?>"><?php echo $request['status']; ?></span></p>
                    
                    <?php if($request['status'] === 'Новая'): ?>
                        <form action="update_status.php" method="post" style="margin-top: 10px;">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" name="status" value="В работе">Взять в работу</button>
                            <button type="submit" name="status" value="Отменена">Отменить</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="nav">
            <a href="admin_logout.php">Выйти</a>
        </div>
    </div>
</body>
</html>
