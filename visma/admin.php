<?php
require_once('./php/db.php');
session_start();
if (!$_SESSION) {
    header('Location: register_form.php');
    exit;
}

if ($_SESSION['is_admin'] == 0) {
    header("Location: index.php");
    exit;
}

$query = "SELECT users.login, services.name_service, statuses.status, user_services.id_user_service, statuses.id_status
FROM user_services
JOIN users ON users.id_user = user_services.id_user 
JOIN services ON services.id_service = user_services.id_service
JOIN statuses ON statuses.id_status = user_services.id_status";

$services = mysqli_query($conn, $query);

// Получаем все статусы
$statuses = [];
$result = mysqli_query($conn, "SELECT * FROM statuses");
while ($row = mysqli_fetch_assoc($result)) {
    $statuses[] = $row;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <?php
 while ($row = mysqli_fetch_assoc($services)):?>
 <form action="./php/status.php" method="post">
        <input type="hidden" name="id_user_service" value="<?= $row['id_user_service'] ?>">
        <p>Пользователь: <?php  echo($row['login']) ?></p>
        <p> Услуга: <?php echo($row['name_service'])?></p>
        <p> Статус: <?php echo($row['status'])?></p>
        <select name="id_status" id="">
        <?php  foreach ($statuses as $key): ?>
        <option value="<?= $key['id_status'] ?>">
            <?=($key['status']); ?>
        </option> <?php endforeach ?>  
        </select>
 
        <button type="submit">Изменить</button>
 </form>
<?php endwhile ?>

<a href="./php/logout.php">Выход</a>
</body>
</html>