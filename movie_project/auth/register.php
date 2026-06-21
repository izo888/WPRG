<?php

require_once '../init.php';

$userModel = new User($pdo);

$errors = [];

$username = '';
$email = '';
$password = '';
$passwordConfirm = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if ($username === '') {
        $errors['username'] = 'Nazwa użytkownika jest wymagana.';
    } elseif (strlen($username) < 3) {
        $errors['username'] = 'Nazwa użytkownika musi mieć minimum 3 znaki.';
    }

    if ($email === '') {
        $errors['email'] = 'Email jest wymagany.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Podaj poprawny adres email.';
    } elseif ($userModel->emailExists($email)) {
        $errors['email'] = 'Użytkownik z takim emailem już istnieje.';
    }

    if ($password === '') {
        $errors['password'] = 'Hasło jest wymagane.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Hasło musi mieć minimum 6 znaków.';
    }

    if ($passwordConfirm === '') {
        $errors['password_confirm'] = 'Powtórzenie hasła jest wymagane.';
    } elseif ($password !== $passwordConfirm) {
        $errors['password_confirm'] = 'Hasła nie są takie same.';
    }

    if (empty($errors)) {
        $userModel->create($username, $email, $password);

        setMessage('Konto zostało utworzone. Możesz się zalogować.');
        header('Location: login.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body class="<?= isDarkTheme() ? 'dark' : '' ?>">

<h1>Rejestracja</h1>

<a class="btn" href="login.php">Masz już konto? Zaloguj się</a>
<br><br>

<?php showMessage(); ?>

<form method="POST">
    <div>
        <label>Nazwa użytkownika:</label><br>
        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
        <?php if (isset($errors['username'])): ?>
            <div style="color: red;"><?= htmlspecialchars($errors['username']) ?></div>
        <?php endif; ?>
    </div>

    <br>

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

    <div>
        <label>Powtórz hasło:</label><br>
        <input type="password" name="password_confirm">
        <?php if (isset($errors['password_confirm'])): ?>
            <div style="color: red;"><?= htmlspecialchars($errors['password_confirm']) ?></div>
        <?php endif; ?>
    </div>

    <br>

    <button type="submit">Zarejestruj</button>
</form>

</body>
</html>