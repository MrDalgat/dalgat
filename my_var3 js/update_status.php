<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['admin']) || !isset($_POST['request_id']) || !isset($_POST['status'])) {
    header("Location: admin.php");
    exit();
}

$request_id = $_POST['request_id'];
$status = $_POST['status'];

$stmt = $conn->prepare("UPDATE requests SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $request_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Статус заявки успешно обновлен";
} else {
    $_SESSION['error'] = "Ошибка при обновлении статуса";
}

header("Location: admin.php");
?>
