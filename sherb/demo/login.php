<?php
// Используем абсолютный путь к файлу подключения
include __DIR__ . '/connect.php';
include 'inc/header.php';

// Обработка входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$login = $_POST['login'] ?? '';
	$password = $_POST['password'] ?? '';

	// Проверка администратора
	if ($login === 'admin' && $password === 'gruzovik2024') {
		$_SESSION['user_id'] = 1;
		$_SESSION['is_admin'] = true;
		header('Location: profile.php');
		exit;
	}
	// Проверка обычных пользователей
	else {
		$stmt = $pdo->prepare("SELECT id, password FROM users WHERE login = ?");
		$stmt->execute([$login]);
		$user = $stmt->fetch();

		if ($user && password_verify($password, $user['password'])) {
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['is_admin'] = false;
			header('Location: profile.php');
			exit;
		} else {
			$error = 'Неверные учетные данные';
		}
	}
}
?>

<h2>Вход</h2>

<?php if (!empty($error)): ?>
	<div style="color: red; padding: 10px; border: 1px solid red; margin: 10px 0; text-align: center;">
		<?= $error ?>
	</div>
<?php endif; ?>

<form method="POST">
	<label>Логин: <input type="text" name="login" required></label><br>
	<label>Пароль: <input type="password" name="password" required></label><br>
	<button type="submit">Войти</button>
</form>

<?php include 'inc/footer.php'; ?>