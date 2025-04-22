<?php

include_once 'Database.php';
$db = new Database();
$db->connect();
$db->generateTables();



?>