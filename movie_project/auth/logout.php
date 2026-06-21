<?php

require_once '../init.php';

session_unset();
session_destroy();

session_start();
setMessage('Wylogowano pomyślnie.');

header('Location: login.php');
exit;