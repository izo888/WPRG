<?php

require_once '../init.php';
requireLogin();

$movieModel = new Movie($pdo);

$search = trim($_GET['search'] ?? '');

if ($search !== '') {
    $movies = $movieModel->search($search);
} else {
    $movies = $movieModel->getAll();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista filmów</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<<body class="<?= isDarkTheme() ? 'dark' : '' ?>">>

<h1>Lista filmów</h1>
<p>
    Zalogowany jako: <?= htmlspecialchars($_SESSION['username'] ?? 'Gość') ?>
    |
    <a href="../dashboard.php">Panel główny</a>
    ||
    <a href="../categories/index.php">Kategorie</a>
    <a href="../theme.php">
        <?= isDarkTheme() ? 'Tryb jasny' : 'Tryb ciemny' ?>
    </a>
    |
    <a href="../auth/logout.php">Wyloguj</a>
</p>
<a class="btn" href="create.php">Dodaj film</a>
<br><br>

<form method="GET">
    <label>Szukaj filmu:</label><br>
    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Tytuł, reżyser lub kategoria">
    <br><br>
    <button type="submit">Szukaj</button>
    <a class="btn" href="index.php">Wyczyść</a>
</form>

<br>
<br><br>

<?php showMessage(); ?>
<?php if (empty($movies)): ?>
    <p>Brak filmów do wyświetlenia.</p>
<?php endif; ?>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Tytuł</th>
        <th>Reżyser</th>
        <th>Rok</th>
        <th>Kategoria</th>
        <th>Plakat</th>
        <th>Data dodania</th>
        <th>Akcje</th>
    </tr>

    <?php foreach ($movies as $movie): ?>
        <tr>
            <td><?= htmlspecialchars($movie['id']) ?></td>
            <td><?= htmlspecialchars($movie['title']) ?></td>
            <td><?= htmlspecialchars($movie['director']) ?></td>
            <td><?= htmlspecialchars($movie['release_year']) ?></td>
            <td><?= htmlspecialchars($movie['category_name'] ?? 'Brak') ?></td>
            <td>
                <?php if (!empty($movie['poster'])): ?>
                    <img src="../uploads/posters/<?= htmlspecialchars($movie['poster']) ?>" width="80">
                <?php else: ?>
                    Brak
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($movie['created_at']) ?></td>
            <td>
                <a href="show.php?id=<?= $movie['id'] ?>">Szczegóły</a>
                |
                <a href="edit.php?id=<?= $movie['id'] ?>">Edytuj</a>
                |
                <a href="delete.php?id=<?= $movie['id'] ?>" onclick="return confirm('Na pewno usunąć film?')">Usuń</a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>