<?php
include_once 'config.php';
include_once 'Router.php';
include_once 'Database.php';
include_once 'View.php';


$router = new Router();

$router->addRoute('GET', '/', function() {
    View::render('about');

});
$router->addRoute('GET', '/home', function() {
    View::render('home');
});













$router->handleRequest();
?>