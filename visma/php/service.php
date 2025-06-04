<?php

require_once('db.php');
session_start();
$service_field = $_POST['service_field'];
$user = $_SESSION['id_user'];
$query = "INSERT INTO `user_services` (`id_service`, `id_user`) VALUES ('$service_field', '$user')";

if (mysqli_query($conn, $query)) {
    die('Успешный заказ!');
} 