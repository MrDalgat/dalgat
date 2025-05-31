<!-- login.php -->
<?php
    include "config.php";

    $login = $_POST['login'];
    $password = $_POST['password'];
    $query = mysqli_query($connection, "SELECT * FROM user WHERE `login` = '$login' and `password` = '$password'");
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $count = mysqli_num_rows($query);
    if ($count == 1) {
        session_start();
        $_SESSION['login_user'] = $email;
        header("location: home.html");
    }
    else {
        echo ' <div class="error"><p>Неправильные данные</p></div>';
    }
?>