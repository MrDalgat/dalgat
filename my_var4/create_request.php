<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$stmt = $conn->query("SELECT id, name FROM courses ORDER BY name");
$courses = $stmt->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Запись на курс - Корочки.есть</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <h1>Запись на курс</h1>
        <form action="save_request.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label>Выберите курс:</label>
                <select name="course_id" required>
                    <option value="">-- Выберите курс --</option>
                    <?php foreach($courses as $course): ?>
                        <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Дата начала обучения:</label>
                <input type="date" name="start_date" id="start_date" required>
            </div>
            <div class="form-group">
                <label>Способ оплаты:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="payment_method" value="Наличные" required> Наличными
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="Банковский перевод" required> Банковский перевод
                    </label>
                </div>
            </div>
            <div id="error" class="error" style="display: none;"></div>
            <button type="submit">Отправить заявку</button>
        </form>
        <div class="nav">
            <a href="index.php">На главную</a>
            <a href="my_requests.php">Мои заявки</a>
        </div>
    </div>

    <script>
    function validateForm() {
        const startDate = new Date(document.getElementById('start_date').value);
        const today = new Date();
        const error = document.getElementById('error');

        error.style.display = 'none';

        if (startDate < today) {
            error.textContent = 'Дата начала обучения не может быть в прошлом';
            error.style.display = 'block';
            return false;
        }

        return true;
    }

    // Устанавливаем минимальную дату
    const dateInput = document.getElementById('start_date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;
    </script>
</body>
</html>
