<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['request_id']) || !isset($_POST['review_text'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$request_id = $_POST['request_id'];
$review_text = $_POST['review_text'];

// Проверяем, принадлежит ли заявка пользователю и завершено ли обучение
$check = $conn->prepare("SELECT id FROM requests WHERE id = ? AND user_id = ? AND status = 'Обучение завершено'");
$check->bind_param("ii", $request_id, $user_id);
$check->execute();
if ($check->get_result()->num_rows === 0) {
    $_SESSION['error'] = "Доступ запрещен или обучение не завершено";
    header("Location: my_requests.php");
    exit();
}

$stmt = $conn->prepare("INSERT INTO reviews (request_id, user_id, review_text) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $request_id, $user_id, $review_text);

if ($stmt->execute()) {
    $_SESSION['success'] = "Отзыв успешно добавлен";
} else {
    $_SESSION['error'] = "Ошибка при добавлении отзыва";
}

header("Location: my_requests.php");
?>
