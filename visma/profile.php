<?php
session_start();

if(!($_SESSION)){
    header('Location: register_form.php');
}

if($_SESSION['is_admin'] == 1){
    header("Location: admin.php");
}
require_once('./php/db.php');

$result = mysqli_query($conn, "SELECT * FROM `services`");
$services = [];
while ($row = mysqli_fetch_assoc($result)) {
    $services[] = $row;
}
$user_id = $_SESSION['id_user'];
$history_query = mysqli_query($conn, "SELECT statuses.status, services.name_service, services.sell_service
FROM services
JOIN user_services ON user_services.id_service = services.id_service
JOIN users ON user_services.id_user = users.id_user
JOIN statuses ON user_services.id_status = statuses.id_status
WHERE users.id_user = '$user_id'");
$history = [];
while ($row = mysqli_fetch_assoc($history_query)) {
    $history[] = $row;
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
    <p> <?php echo($_SESSION['login']) ?> </p>
    <p> <?php echo($_SESSION['email']) ?> </p>

    <a href="./php/logout.php">logout</a>
    
    <form action="./php/service.php" method="post">
        <select name="service_field" >
        <?php foreach ($services as $service): ?>
        <option value=" <?= $service['id_service'] ?> ">
            <?= $service['name_service'] ?>
        </option>
    <?php endforeach; ?>
        </select>
        <button type="submit">Отправить</button>
        <?php foreach ($history as $record): ?>
    <p>Услуга: <?=$record['name_service'] ?></p>
    <p>Стоимость: <?= $record['sell_service'] ?></p>
    <p>Статус: <?= $record['status'] ?></p>
<?php endforeach; ?>
    </form>
    
    
</body>
</html>