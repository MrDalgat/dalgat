<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="./php/feedback.php" method="post">
        <input type="text" name="name" placeholder="Введите ваше имя" required>
        <textarea name="message" placeholder="Ваш вопрос" required></textarea>
        <button type="submit">Отправить</button>
        <p>Отправь свой вопрос!</p>
    </form>
</body>
</html>