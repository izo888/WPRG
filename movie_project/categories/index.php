<?php

require_once '../init.php';

requireLogin();

$categoryModel = new Category($pdo);
$categories = $categoryModel->getAll();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kategorie</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body class="<?= isDarkTheme() ? 'dark' : '' ?>">

<h1>Kategorie</h1>

<p>
    Zalogowany jako: <?= htmlspecialchars($_SESSION['username'] ?? 'Gość') ?>
    |
    <a href="../dashboard.php">Panel główny</a>
    |
    <a href="../movies/index.php">Lista filmów</a>
    |
    <a href="../theme.php">
        <?= isDarkTheme() ? 'Tryb jasny' : 'Tryb ciemny' ?>
    </a>
    |
    <a href="../auth/logout.php">Wyloguj</a>
</p>

<?php showMessage(); ?>

<a class="btn" href="create.php">Dodaj kategorię</a>

<br><br>

<table>
    <tr>
        <th>ID</th>
        <th>Nazwa</th>
        <th>Akcje</th>
    </tr>

    <?php foreach ($categories as $category): ?>
        <tr>
            <td><?= htmlspecialchars($category['id']) ?></td>
            <td><?= htmlspecialchars($category['name']) ?></td>
            <td>
                <a href="edit.php?id=<?= $category['id'] ?>">Edytuj</a>
                |
                <a href="delete.php?id=<?= $category['id'] ?>" onclick="return confirm('Na pewno usunąć kategorię?')">Usuń</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>