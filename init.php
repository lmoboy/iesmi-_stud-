<?php

$lines = file('.env');
foreach ($lines as $line) {
    [$key, $value] = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);

    putenv(sprintf('%s=%s', $key, $value));
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}


include_once './utils/config.php';
include_once './utils/Database.php';
$db = new Database();



$db->dropTables();
$db->generateTables();



?>