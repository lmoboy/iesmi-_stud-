<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IESMINS_STUDE</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script defer src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
</html>

<?php
require_once 'config.php';
require_once 'Router.php';
require_once 'View.php';
require_once 'Database.php';

$router = new Router();

// Auth routes
$router->addRoute('POST', '/backend/login', function() {
    require_once 'backend/loginController.php';
});

$router->addRoute('GET', '/logout', function() {
    session_destroy();
    header('Location: /');
    exit();
});

// Home route
$router->addRoute('GET', '/', function() {
    if (isset($_SESSION['user'])) {
        View::render('home');
    } else {
        View::render('login');
    }
});

// Example protected route
$router->addRoute('GET', '/home', function() {
    if (!isset($_SESSION['user'])) {
        header('Location: /');
        exit();
    }
    View::render('home');
});

// 404 fallback handled by Router.php
$router->handleRequest();
?>
