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
require_once 'utils\config.php';
require_once 'utils\Router.php';
require_once 'utils\View.php';
require_once 'utils\Database.php';

$router = new Router();


//--------------------------------BACKEND--------------------------------

$router->addRoute('POST', '/backend/login', function() {
    require_once 'backend\loginHandle.php';
});


$router->addRoute('GET', '/backend/logout', function() {
    session_destroy();
    header('Location: /');
    exit();
});


//--------------------------------FRONTEND--------------------------------
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
