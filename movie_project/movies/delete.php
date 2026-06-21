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

if (!empty($movie['poster'])) {
    $posterPath = '../uploads/posters/' . $movie['poster'];

    if (file_exists($posterPath)) {
        unlink($posterPath);
    }
}

$movieModel->delete($id);

setMessage('Film został usunięty.');
header('Location: index.php');
exit;