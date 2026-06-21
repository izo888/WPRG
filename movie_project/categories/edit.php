<?php

require_once '../init.php';

requireLogin();

$categoryModel = new Category($pdo);

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    setMessage('Nieprawidłowe ID kategorii.');
    header('Location: index.php');
    exit;
}

$category = $categoryModel->getById($id);

if (!$category) {
    setMessage('Nie znaleziono kategorii.');
    header('Location: index.php');
    exit;
}

$errors = [];
$name = $category['name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Nazwa kategorii jest wymagana.';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'Nazwa kategorii musi mieć minimum 2 znaki.';
    }

    if (empty($errors)) {
        $categoryModel->update($id, $name);

        setMessage('Kategoria została zaktualizowana.');
        header('Location: index.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj kategorię</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body class="<?= isDarkTheme() ? 'dark' : '' ?>">

<h1>Edytuj kategorię</h1>

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

    <button type="submit">Zapisz zmiany</button>
</form>

</body>
</html>