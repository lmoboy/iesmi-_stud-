<?php
// Start the session at the beginning
session_start();

// Database Configuration
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);

// Application Configuration
define('BASE_URL', 'http://localhost');
define('APP_NAME', 'IESMINS_STUDĒ');

// Debug Configuration
define('DEBUG_MODE', true);
define('DEBUG_DB', true);
define('DEBUG_ROUTER', true);
define('DEBUG_VIEW', true);
define('DEBUG_AUTH', true);

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug Log File
define('DEBUG_LOG_FILE', './logs/debug.log');

// Create logs directory if it doesn't exist
if (!file_exists('../logs')) {
    mkdir('../logs', 0777, true);
}