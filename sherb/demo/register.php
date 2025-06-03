<?php
// Используем абсолютный путь к файлу подключения
include __DIR__ . '/connect.php';
include 'inc/header.php';

// Обработка регистрации
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fio = $_POST['fio'] ?? '';
	$phone = $_POST['phone'] ?? '';
	$email = $_POST['email'] ?? '';
	$login = $_POST['login'] ?? '';
	$password = $_POST['password'] ?? '';

	// Блокировка регистрации администратора
	if ($login === 'admin') {
		$error = 'Логин "admin" зарезервирован';
	} else {
		// Проверка уникальности логина
		$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login = ?");
		$stmt->execute([$login]);
		$loginExists = $stmt->fetchColumn() > 0;

		// Проверка уникальности email
		$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
		$stmt->execute([$email]);
		$emailExists = $stmt->fetchColumn() > 0;

		if ($loginExists) {
			$error = 'Пользователь с таким логином уже существует';
		} elseif ($emailExists) {
			$error = 'Пользователь с таким email уже существует';
		} else {
			// Хеширование пароля
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

			// Вставка в БД
			$stmt = $pdo->prepare("INSERT INTO users (fio, phone, email, login, password) VALUES (?, ?, ?, ?, ?)");
			$stmt->execute([$fio, $phone, $email, $login, $hashedPassword]);

			$success = 'Регистрация успешна!';
			echo '<meta http-equiv="refresh" content="2;url=login.php">';
		}
	}
}
?>

<h2>Регистрация</h2>

<?php if ($error): ?>
	<div style="color: red; padding: 10px; border: 1px solid red; margin: 10px 0; text-align: center;">
		<?= $error ?>
	</div>
<?php endif; ?>

<?php if ($success): ?>
	<div style="color: green; padding: 10px; border: 1px solid green; margin: 10px 0; text-align: center;">
		<?= $success ?>
	</div>
<?php endif; ?>

<form method="POST">
	<label>ФИО: <input type="text" name="fio" required></label><br>
	<label>Телефон: <input type="text" name="phone" placeholder="+7(123)-456-78-90" required></label><br>
	<label>Email: <input type="email" name="email" required></label><br>
	<label>Логин: <input type="text" name="login" required></label><br>
	<label>Пароль: <input type="password" name="password" required></label><br>
	<button type="submit">Зарегистрироваться</button>
</form>

<?php include 'inc/footer.php'; ?>