<?php
$conn = new mysqli('localhost', 'root', 'root', 'korochki2');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
