<?php

require_once '../init.php';

$userModel = new User($pdo);

$errors = [];

$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $errors['email'] = 'Email jest wymagany.';
    }

    if ($password === '') {
        $errors['password'] = 'Hasło jest wymagane.';
    }

    if (empty($errors)) {
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors['login'] = 'Nieprawidłowy email lub hasło.';
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            setMessage('Zalogowano pomyślnie.');
            header('Location: ../dashboard.php');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body class="<?= isDarkTheme() ? 'dark' : '' ?>">

<h1>Logowanie</h1>

<a class="btn" href="register.php">Nie masz konta? Zarejestruj się</a>
<br><br>

<?php showMessage(); ?>

<?php if (isset($errors['login'])): ?>
    <div class="error">
    <br>
<?php endif; ?>

<form method="POST">
    <div>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
        <?php if (isset($errors['email'])): ?>
            <div style="color: red;"><?= htmlspecialchars($errors['email']) ?></div>
        <?php endif; ?>
    </div>

    <br>

    <div>
        <label>Hasło:</label><br>
        <input type="password" name="password">
        <?php if (isset($errors['password'])): ?>
            <div style="color: red;"><?= htmlspecialchars($errors['password']) ?></div>
        <?php endif; ?>
    </div>

    <br>

    <button type="submit">Zaloguj</button>
</form>

</body>
</html>