<?php

include_once 'config.php';
include_once 'Database.php';
$db = new Database();



$db->connect();
$db->generateTables();
$db->query('INSERT INTO users (email, password, role) VALUES ("admin@admin.com", '. password_hash('admin', PASSWORD_DEFAULT) .', "admin")');



?>