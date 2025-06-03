<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM requests WHERE user_id = ? ORDER BY date_time DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Мои заявки - Грузовозофф</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <h1>Мои заявки</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if($result->num_rows > 0): ?>
            <div class="request-list">
                <?php while($request = $result->fetch_assoc()): ?>
                    <div class="request-item">
                        <p><strong>Дата и время:</strong> <?php echo $request['date_time']; ?></p>
                        <p><strong>Вес:</strong> <?php echo htmlspecialchars($request['weight']); ?> кг</p>
                        <p><strong>Габариты:</strong> <?php echo htmlspecialchars($request['dimensions']); ?></p>
                        <p><strong>Тип груза:</strong> <?php echo htmlspecialchars($request['cargo_type']); ?></p>
                        <p><strong>Откуда:</strong> <?php echo htmlspecialchars($request['from_address']); ?></p>
                        <p><strong>Куда:</strong> <?php echo htmlspecialchars($request['to_address']); ?></p>
                        <p><strong>Статус:</strong> <span class="status-<?php echo strtolower($request['status']); ?>"><?php echo $request['status']; ?></span></p>
                        
                        <?php if($request['status'] !== 'Отменена'): ?>
                            <form action="add_review.php" method="post" style="margin-top: 10px;">
                                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                <div class="form-group">
                                    <textarea name="review_text" placeholder="Оставить отзыв о перевозке" required></textarea>
                                </div>
                                <button type="submit">Отправить отзыв</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>У вас пока нет заявок</p>
        <?php endif; ?>

        <div class="nav">
            <a href="create_request.php" class="button">Создать новую заявку</a>
            <a href="index.php">На главную</a>
        </div>
    </div>
</body>
</html>
