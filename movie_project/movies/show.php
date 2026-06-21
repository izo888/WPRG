<?php

require_once '../init.php';
requireLogin();

$movieModel = new Movie($pdo);

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    setMessage('Nieprawidłowe ID filmu.');
    header('Location: index.php');
    exit;
}

$movie = $movieModel->getById($id);

if (!$movie) {
    setMessage('Nie znaleziono filmu.');
    header('Location: index.php');
    exit;
}

$categoryModel = new Category($pdo);
$categories = $categoryModel->getAll();

$categoryName = 'Brak';

foreach ($categories as $category) {
    if ($category['id'] == $movie['category_id']) {
        $categoryName = $category['name'];
        break;
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Szczegóły filmu</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body class="<?= isDarkTheme() ? 'dark' : '' ?>">

<h1>Szczegóły filmu</h1>

<a class="btn" href="index.php">Powrót do listy</a>
<a class="btn" href="edit.php?id=<?= htmlspecialchars($movie['id']) ?>">Edytuj</a>
<a class="btn" href="delete.php?id=<?= htmlspecialchars($movie['id']) ?>" onclick="return confirm('Na pewno usunąć film?')">Usuń</a>
<br><br>

<h2><?= htmlspecialchars($movie['title']) ?></h2>

<p>
    <strong>Reżyser:</strong>
    <?= htmlspecialchars($movie['director']) ?>
</p>

<p>
    <strong>Rok wydania:</strong>
    <?= htmlspecialchars($movie['release_year']) ?>
</p>

<p>
    <strong>Kategoria:</strong>
    <?= htmlspecialchars($categoryName) ?>
</p>

<p>
    <strong>Opis:</strong><br>
    <?= nl2br(htmlspecialchars($movie['description'])) ?>
</p>

<p>
    <strong>Data dodania:</strong>
    <?= htmlspecialchars($movie['created_at']) ?>
</p>

<?php if (!empty($movie['poster'])): ?>
    <p>
        <strong>Plakat:</strong><br>
        <img src="../uploads/posters/<?= htmlspecialchars($movie['poster']) ?>" width="250">
    </p>
<?php else: ?>
    <p><strong>Plakat:</strong> Brak</p>
<?php endif; ?>

</body>
</html>