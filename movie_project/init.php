<?php

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/classes/Movie.php';
require_once __DIR__ . '/classes/Category.php';
require_once __DIR__ . '/classes/User.php';
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: /movie_project/auth/login.php');
        exit;
    }
}

function setMessage($message)
{
    $_SESSION['message'] = $message;
}

function showMessage()
{
    if (isset($_SESSION['message'])) {
        echo '<div class="message">' . htmlspecialchars($_SESSION['message']) . '</div>';
        unset($_SESSION['message']);
    }
}
function getTheme()
{
    return $_COOKIE['theme'] ?? 'light';
}

function isDarkTheme()
{
    return getTheme() === 'dark';
}