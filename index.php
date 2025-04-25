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
require_once __DIR__ . '\utils\config.php';
require_once __DIR__ . '\utils\Router.php';
require_once __DIR__ . '\utils\View.php';
require_once __DIR__ . '\utils\Database.php';

$router = new Router();


//--------------------------------BACKEND--------------------------------

$router->addRoute('POST', '/backend/login', function () {
    require_once 'backend\loginHandle.php';
});


$router->addRoute('GET', '/backend/logout', function () {
    session_destroy();
    header('Location: /');
    exit();
});


//--------------------------------FRONTEND--------------------------------
$router->addRoute('GET', '/', function () {
    if (isset($_SESSION['user'])) {
        View::render('home');
    } else {
        View::render('login');
    }
});

$router->addRoute('GET', '/profile', function () {
    if (isset($_SESSION['user'])) {
        View::render('user/profile');
    } else {
        header("Location: /");
        exit;
    }
});


$router->addRoute("GET", "/teacher", function () {
    if (!isset($_SESSION['user'])) {
        header("Location: /");
        exit;
    }
    View::render('teacher');
});











//----------------------------FRONTEND-ADMIN---------------------------------


$router->addRoute("GET", "/admin", function () {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        header("Location: /");
        exit;
    }
    View::render('admin');
});

$router->addRoute("GET", "/add-user", function () {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        header("Location: /");
        exit;
    }
    View::render('user/addUser');
});

$router->addRoute('GET', '/edit-user', function () {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        header("Location: /");
        exit;
    }
    $userID = $_GET['id'];
    View::render('user/editUser', ['id' => $userID]);
});

$router->handleRequest();
?>