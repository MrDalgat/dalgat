<?php

$username = 'root';
$dbname = 'lesson';
$password = '';
$host = 'localhost';

 if (!$conn = mysqli_connect($host,$username,$password,$dbname)) {
    die("Нет подключения");
 }

