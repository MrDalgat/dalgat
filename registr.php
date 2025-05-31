<!-- registr.php -->
<?php
    require_once('config.php');
    $login = $_POST['login'];
    $password = $_POST["password"];  
    $fio = $_POST['fio']; 
    $telephone = $_POST['phone']; 
    $email = $_POST['email']; 
    $sql = mysqli_query($connection, "INSERT INTO user (`login`, `password`, `FIO`, `phone`, `email`, `admin`) 
        VALUES ('$login', '$password', '$fio', '$telephone', '$email', '0' )");
    session_start();
    $_SESSION['login_user'] = $email;
    header('Location: home.html');
?>