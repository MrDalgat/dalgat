<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $date_time = $_POST['date_time'];
    $weight = $_POST['weight'];
    $dimensions = $_POST['dimensions'];
    $cargo_type = $_POST['cargo_type'];
    $from_address = $_POST['from_address'];
    $to_address = $_POST['to_address'];

    $stmt = $conn->prepare("INSERT INTO requests (user_id, date_time, weight, dimensions, cargo_type, from_address, to_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $user_id, $date_time, $weight, $dimensions, $cargo_type, $from_address, $to_address);

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
