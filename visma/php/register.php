<?php
require_once('db.php');

$login = $_POST['login'];
$password = $_POST['password'];
$repeatpassword = $_POST['repeatpassword'];
$email = $_POST['email'];

if ($password != $repeatpassword) {
    die('Пароли не совпадают!');
}elseif (strlen($password) < 6) {
    die('Введите более 6 символов');
} elseif (!preg_match("/[A-Z]/", $password)) {
    die('Пароль должен содержать заглавную букву!');
} else{
    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE `login` = '$login' or `email` = '$email'");
    if (mysqli_num_rows($check_user) > 0 ) {
        die('Такой пользователь уже есть!');
    } else{
        $password = md5($password);
        $query = "INSERT INTO `users` (`login`, `password`, `email`) VALUES ('$login', '$password', '$email')";
        mysqli_query($conn,$query);
        echo "Успешная регистрация,  <a href='../login_form.php'>Войдите!</a>";
                
    }
}
