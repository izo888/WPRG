<?php

require_once '../init.php';
requireLogin();

$movieModel = new Movie($pdo);
$categoryModel = new Category($pdo);
$categories = $categoryModel->getAll();

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

$errors = [];

$title = $movie['title'];
$director = $movie['director'];
$releaseYear = $movie['release_year'];
$description = $movie['description'];
$categoryId = $movie['category_id'];
$currentPoster = $movie['poster'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $director = trim($_POST['director'] ?? '');
    $releaseYear = trim($_POST['release_year'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $categoryId = $_POST['category_id'] ?? '';

    if ($title === '') {
        $errors['title'] = 'Tytuł jest wymagany.';
    }

    if ($director === '') {
        $errors['director'] = 'Reżyser jest wymagany.';
    }

    if ($releaseYear === '') {
        $errors['release_year'] = 'Rok wydania jest wymagany.';
    } elseif (!is_numeric($releaseYear)) {
        $errors['release_year'] = 'Rok musi być liczbą.';
    } elseif ($releaseYear < 1888 || $releaseYear > date('Y') + 1) {
        $errors['release_year'] = 'Podaj poprawny rok wydania.';
    }

    if ($categoryId === '') {
        $errors['category_id'] = 'Kategoria jest wymagana.';
    }

    $posterName = $currentPoster;

    if (isset($_FILES['poster']) && $_FILES['poster']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['poster']['error'] !== UPLOAD_ERR_OK) {
            $errors['poster'] = 'Wystąpił błąd podczas przesyłania pliku.';
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $fileType = mime_content_type($_FILES['poster']['tmp_name']);

            if (!in_array($fileType, $allowedTypes)) {
                $errors['poster'] = 'Dozwolone formaty plakatu to JPG, PNG lub WEBP.';
            } elseif ($_FILES['poster']['size'] > 2 * 1024 * 1024) {
                $errors['poster'] = 'Plik nie może być większy niż 2 MB.';
            } else {
                $extension = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
                $newPosterName = uniqid('poster_', true) . '.' . strtolower($extension);

                $uploadPath = '../uploads/posters/' . $newPosterName;

                if (move_uploaded_file($_FILES['poster']['tmp_name'], $uploadPath)) {
                    if (!empty($currentPoster)) {
                        $oldPosterPath = '../uploads/posters/' . $currentPoster;

                        if (file_exists($oldPosterPath)) {
                            unlink($oldPosterPath);
                        }
                    }

                    $posterName = $newPosterName;
                } else {
                    $errors['poster'] = 'Nie udało się zapisać plakatu.';
                }
            }
        }
    }

    if (empty($errors)) {
        $movieModel->update(
            $id,
            $title,
            $director,
            $releaseYear,
            $description,
            $categoryId,
            $posterName
        );

        setMessage('Film został zaktualizowany.');
        header('Location: index.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj film</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body class="<?= isDarkTheme() ? 'dark' : '' ?>">

<h1>Edytuj film</h1>

<a class="btn" href="index.php">Powrót do listy</a>
<a class="btn" href="show.php?id=<?= htmlspecialchars($movie['id']) ?>">Szczegóły</a>

<br><br>

<form method="POST" enctype="multipart/form-data">
    <div>
        <label>Tytuł:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>">
        <?php if (isset($errors['title'])): ?>
            <div style="color: red;"><?= htmlspecialchars($errors['title']) ?></div>
        <?php endif; ?>
    </div>

    <br>

    <div>
        <label>Reżyser:</label><br>
        <input type="text" name="director" value="<?= htmlspecialchars($director) ?>">
        <?php if (isset($errors['director'])): ?>
            <div style="color: red;"><?= htmlspecialchars($errors['director']) ?></div>
        <?php endif; ?>
    </div>

    <br>

    <div>
        <label>Rok wydania:</label><br>
        <input type="number" name="release_year" value="<?= htmlspecialchars($releaseYear) ?>">
        <?php if (isset($errors['release_year'])): ?>
            <div style="color: red;"><?= htmlspecialchars($errors['release_year']) ?></div>
        <?php endif; ?>
    </div>

    <br>

    <div>
        <label>Opis:</label><br>
        <textarea name="description" rows="5" cols="40"><?= htmlspecialchars($description) ?></textarea>
    </div>

    <br>

    <div>
        <label>Kategoria:</label><br>
        <select name="category_id">
            <option value="">-- wybierz kategorię --</option>

            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"
                    <?= $categoryId == $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <?php if (isset($errors['category_id'])): ?>
            <div style="color: red;"><?= htmlspecialchars($errors['category_id']) ?></div>
        <?php endif; ?>
    </div>

    <br>

    <div>
        <label>Obecny plakat:</label><br>

        <?php if (!empty($currentPoster)): ?>
            <img src="../uploads/posters/<?= htmlspecialchars($currentPoster) ?>" width="150">
        <?php else: ?>
            Brak plakatu
        <?php endif; ?>
    </div>

    <br>

    <div>
        <label>Nowy plakat:</label><br>
        <input type="file" name="poster">
        <?php if (isset($errors['poster'])): ?>
            <div style="color: red;"><?= htmlspecialchars($errors['poster']) ?></div>
        <?php endif; ?>
    </div>

    <br>

    <button type="submit">Zapisz zmiany</button>
</form>

</body>
</html>