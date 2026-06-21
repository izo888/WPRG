<?php

require_once 'init.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

header('Location: auth/login.php');
exit;