<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Создание заявки - Грузовозофф</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <h1>Создание заявки на перевозку</h1>
        <form action="save_request.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label>Дата и время перевозки:</label>
                <input type="datetime-local" name="date_time" required>
            </div>
            <div class="form-group">
                <label>Вес груза (кг):</label>
                <input type="text" name="weight" required>
            </div>
            <div class="form-group">
                <label>Габариты (ДxШxВ см):</label>
                <input type="text" name="dimensions" placeholder="100x50x50" required>
            </div>
            <div class="form-group">
                <label>Тип груза:</label>
                <select name="cargo_type" required>
                    <option value="">Выберите тип груза</option>
                    <option value="хрупкое">Хрупкое</option>
                    <option value="скоропортящееся">Скоропортящееся</option>
                    <option value="рефрижератор">Требуется рефрижератор</option>
                    <option value="животные">Животные</option>
                    <option value="жидкость">Жидкость</option>
                    <option value="мебель">Мебель</option>
                    <option value="мусор">Мусор</option>
                </select>
            </div>
            <div class="form-group">
                <label>Адрес отправления:</label>
                <textarea name="from_address" required></textarea>
            </div>
            <div class="form-group">
                <label>Адрес доставки:</label>
                <textarea name="to_address" required></textarea>
            </div>
            <div id="error" class="error"></div>
            <button type="submit">Отправить заявку</button>
        </form>
        <div class="nav">
            <a href="index.php">На главную</a>
            <a href="my_requests.php">Мои заявки</a>
        </div>
    </div>

    <script>
    function validateForm() {
        const dateTime = document.querySelector('input[name="date_time"]').value;
        const weight = document.querySelector('input[name="weight"]').value;
        const dimensions = document.querySelector('input[name="dimensions"]').value;
        const error = document.getElementById('error');

        const now = new Date();
        const selectedDate = new Date(dateTime);

        if (selectedDate < now) {
            error.textContent = 'Дата и время не могут быть в прошлом';
            return false;
        }

        if (isNaN(weight) || weight <= 0) {
            error.textContent = 'Введите корректный вес';
            return false;
        }

        if (!/^\d+x\d+x\d+$/.test(dimensions)) {
            error.textContent = 'Габариты должны быть в формате ДxШxВ (например: 100x50x50)';
            return false;
        }

        return true;
    }
    </script>
</body>
</html>
