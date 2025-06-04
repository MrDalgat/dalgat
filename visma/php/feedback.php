<?php
require_once('db.php');

$name = $_POST['name'];
$message = $_POST['message'];
$query = "INSERT INTO `feedback` (`username`, `message`) VALUES ('$name', '$message')";
if (mysqli_query($conn, $query)) {
    die('Вопрос отправлен!');
}