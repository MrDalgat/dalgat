<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];
    $start_date = $_POST['start_date'];
    $payment_method = $_POST['payment_method'];

    $stmt = $conn->prepare("INSERT INTO requests (user_id, course_id, start_date, payment_method) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $course_id, $start_date, $payment_method);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Заявка успешно создана";
        header("Location: my_requests.php");
    } else {
        $_SESSION['error'] = "Ошибка при создании заявки: " . $conn->error;
        header("Location: create_request.php");
    }
    exit();
}
?>
