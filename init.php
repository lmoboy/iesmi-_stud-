<?php

include_once './utils/config.php';
include_once './utils/Database.php';
$db = new Database();



$db->dropTables();
$db->generateTables();



?>