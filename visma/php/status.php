<?php
require_once('db.php');
$id_user_service = $_POST['id_user_service'];
$status = $_POST['id_status'];
$query = "UPDATE `user_services` SET `id_status` = $status WHERE id_user_service = $id_user_service";

if ($result = mysqli_query($conn, $query)) {
    die('Запись обновлена');
}