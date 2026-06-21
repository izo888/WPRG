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

if ($categoryModel->hasMovies($id)) {
    setMessage('Nie można usunąć kategorii, ponieważ jest przypisana do filmu.');
    header('Location: index.php');
    exit;
}

$categoryModel->delete($id);

setMessage('Kategoria została usunięta.');
header('Location: index.php');
exit;