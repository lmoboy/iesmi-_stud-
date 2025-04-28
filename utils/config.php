<?php
// Start the session at the beginning
session_start();

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'schooldb');
define('DB_USER', 'root');
define('DB_PASS', 'root');

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