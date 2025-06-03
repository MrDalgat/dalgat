<?php
session_start();
require_once('db.php');

// Проверка авторизации админа
if (!isset($_SESSION['admin'])) {
    if (isset($_POST['login']) && isset($_POST['password'])) {
        if ($_POST['login'] === 'admin' && $_POST['password'] === 'education') {
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
            <title>Админ-панель - Корочки.есть</title>
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

// Получаем параметры фильтрации
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Формируем SQL запрос с фильтрами
$where_clauses = [];
$params = [];
$types = "";

if ($status_filter) {
    $where_clauses[] = "r.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

if ($date_filter) {
    $where_clauses[] = "DATE(r.start_date) = ?";
    $params[] = $date_filter;
    $types .= "s";
}

$where_sql = $where_clauses ? "WHERE " . implode(" AND ", $where_clauses) : "";

// Получаем общее количество записей
$count_sql = "SELECT COUNT(*) FROM requests r $where_sql";
$stmt = $conn->prepare($count_sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$total_records = $stmt->get_result()->fetch_row()[0];
$total_pages = ceil($total_records / $per_page);

// Получаем заявки с пагинацией
$sql = "SELECT r.*, u.fullname, u.phone, u.email, c.name as course_name 
        FROM requests r 
        JOIN users u ON r.user_id = u.id 
        JOIN courses c ON r.course_id = c.id 
        $where_sql 
        ORDER BY r.created_at DESC 
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$types .= "ii";
$params[] = $per_page;
$params[] = $offset;
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Админ-панель - Корочки.есть</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <h1>Панель администратора</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <!-- Фильтры -->
        <div class="filter-section">
            <form method="get">
                <div style="display: flex; gap: 20px; margin-bottom: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Статус:</label>
                        <select name="status">
                            <option value="">Все</option>
                            <option value="Новая" <?php echo $status_filter === 'Новая' ? 'selected' : ''; ?>>Новая</option>
                            <option value="Идет обучение" <?php echo $status_filter === 'Идет обучение' ? 'selected' : ''; ?>>Идет обучение</option>
                            <option value="Обучение завершено" <?php echo $status_filter === 'Обучение завершено' ? 'selected' : ''; ?>>Обучение завершено</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Дата начала:</label>
                        <input type="date" name="date" value="<?php echo $date_filter; ?>">
                    </div>
                </div>
                <button type="submit">Применить фильтры</button>
            </form>
        </div>

        <div class="request-list">
            <?php while($request = $result->fetch_assoc()): ?>
                <div class="request-item">
                    <h3><?php echo htmlspecialchars($request['course_name']); ?></h3>
                    <p><strong>Заказчик:</strong> <?php echo htmlspecialchars($request['fullname']); ?></p>
                    <p><strong>Телефон:</strong> <?php echo htmlspecialchars($request['phone']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($request['email']); ?></p>
                    <p><strong>Дата начала:</strong> <?php echo date('d.m.Y', strtotime($request['start_date'])); ?></p>
                    <p><strong>Способ оплаты:</strong> <?php echo htmlspecialchars($request['payment_method']); ?></p>
                    <p><strong>Статус:</strong> <span class="status-<?php echo strtolower(str_replace(' ', '', $request['status'])); ?>">
                        <?php echo $request['status']; ?>
                    </span></p>
                    
                    <?php if($request['status'] === 'Новая'): ?>
                        <form action="update_status.php" method="post" style="margin-top: 10px;">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" name="status" value="Идет обучение">Начать обучение</button>
                        </form>
                    <?php elseif($request['status'] === 'Идет обучение'): ?>
                        <form action="update_status.php" method="post" style="margin-top: 10px;">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" name="status" value="Обучение завершено">Завершить обучение</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Пагинация -->
        <?php if($total_pages > 1): ?>
            <div class="pagination">
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&status=<?php echo urlencode($status_filter); ?>&date=<?php echo urlencode($date_filter); ?>" 
                       class="button <?php echo $page === $i ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

        <div class="nav">
            <a href="admin_logout.php">Выйти</a>
        </div>
    </div>
</body>
</html>
