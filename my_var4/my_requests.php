<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT r.*, c.name as course_name 
    FROM requests r 
    JOIN courses c ON r.course_id = c.id 
    WHERE r.user_id = ? 
    ORDER BY r.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Мои заявки - Корочки.есть</title>
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
                        <h3><?php echo htmlspecialchars($request['course_name']); ?></h3>
                        <p><strong>Дата начала:</strong> <?php echo date('d.m.Y', strtotime($request['start_date'])); ?></p>
                        <p><strong>Способ оплаты:</strong> <?php echo htmlspecialchars($request['payment_method']); ?></p>
                        <p><strong>Статус:</strong> <span class="status-<?php echo strtolower(str_replace(' ', '', $request['status'])); ?>">
                            <?php echo $request['status']; ?>
                        </span></p>
                        
                        <?php if($request['status'] === 'Обучение завершено'): ?>
                            <form action="add_review.php" method="post" style="margin-top: 10px;">
                                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                <div class="form-group">
                                    <textarea name="review_text" placeholder="Оставьте отзыв о курсе" required></textarea>
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
            <a href="create_request.php" class="button">Записаться на курс</a>
            <a href="index.php">На главную</a>
        </div>
    </div>
</body>
</html>
