<?php

require_once 'init.php';

$currentTheme = getTheme();

if ($currentTheme === 'dark') {
    setcookie('theme', 'light', time() + 60 * 60 * 24 * 30, '/');
} else {
    setcookie('theme', 'dark', time() + 60 * 60 * 24 * 30, '/');
}

$redirect = $_SERVER['HTTP_REFERER'] ?? 'dashboard.php';

header('Location: ' . $redirect);
exit;