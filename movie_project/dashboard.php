<?php

require_once 'init.php';

requireLogin();

$movieModel = new Movie($pdo);
$categoryModel = new Category($pdo);

$totalMovies = $movieModel->countAll();
$totalCategories = $categoryModel->countAll();
$latestMovie = $movieModel->getLatest();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel główny</title>
    <link rel="stylesheet" href="public/style.css">
</head>
<body class="<?= isDarkTheme() ? 'dark' : '' ?>">

<h1>Panel główny</h1>

<p>
    Zalogowany jako:
    <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
    |
    <a href="movies/index.php">Lista filmów</a>
    |
<a href="categories/index.php">Kategorie</a>
    |
    <a href="theme.php">
        <?= isDarkTheme() ? 'Tryb jasny' : 'Tryb ciemny' ?>
    </a>
    |
    <a href="auth/logout.php">Wyloguj</a>
</p>

<?php showMessage(); ?>

<hr>

<h2>Podsumowanie aplikacji</h2>

<ul>
    <li>
        <strong>Liczba filmów:</strong>
        <?= htmlspecialchars($totalMovies) ?>
    </li>

    <li>
        <strong>Liczba kategorii:</strong>
        <?= htmlspecialchars($totalCategories) ?>
    </li>

    <li>
        <strong>Ostatnio dodany film:</strong>
        <?php if ($latestMovie): ?>
            <?= htmlspecialchars($latestMovie['title']) ?>
            — <?= htmlspecialchars($latestMovie['category_name'] ?? 'Brak kategorii') ?>
        <?php else: ?>
            Brak filmów
        <?php endif; ?>
    </li>
</ul>

<hr>

<h2>Szybkie akcje</h2>

<p>
    <a class="btn" href="movies/create.php">Dodaj nowy film</a>
    <a class="btn" href="movies/index.php">Lista filmów</a>
    <a class="btn" href="categories/index.php">Kategorie</a>
</p>

</body>
</html>