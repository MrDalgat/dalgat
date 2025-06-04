<?php

require_once('db.php');
$login = $_POST['login'];
$password =  md5($_POST['password']);

$query = "SELECT * FROM users WHERE `login` = '$login' and `password` = '$password'";
$check_user = mysqli_query($conn, $query);
if (mysqli_num_rows($check_user) < 1) {
    die('Такой пользователь не найден или данные введены неправильно!');
} else{
    $row = mysqli_fetch_assoc($check_user);
    session_start();
    $_SESSION['id_user'] = $row['id_user'];
    $_SESSION['login'] = $row['login'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['is_admin'] = $row['is_admin'];
    header("Location: ../profile.php");
}
