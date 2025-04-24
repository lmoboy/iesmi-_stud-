<?php

include_once 'config.php';
include_once 'Database.php';
$db = new Database();



$db->connect();
$db->dropTables();
$db->generateTables();



?>