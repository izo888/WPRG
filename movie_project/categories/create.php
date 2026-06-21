<?php

require_once '../init.php';

requireLogin();

$categoryModel = new Category($pdo);

$errors = [];
$name = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Nazwa kategorii jest wymagana.';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'Nazwa kategorii musi mieć minimum 2 znaki.';
    }

    if (empty($errors)) {
        $categoryModel->create($name);

        setMessage('Kategoria została dodana.');
        header('Location: index.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj kategorię</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body class="<?= isDarkTheme() ? 'dark' : '' ?>">

<h1>Dodaj kategorię</h1>

<a class="btn" href="index.php">Powrót do kategorii</a>

<br><br>

<form method="POST">
    <div>
        <label>Nazwa kategorii:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">

        <?php if (isset($errors['name'])): ?>
            <div class="error"><?= htmlspecialchars($errors['name']) ?></div>
        <?php endif; ?>
    </div>

    <br>

    <button type="submit">Dodaj kategorię</button>
</form>

</body>
</html>