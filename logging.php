<?php

function debug_log($message, $type = 'info')
{
    $log_message = date('[Y-m-d H:i:s]') . " [CONTROLLER] [{$type}] {$message}\n";
    error_log($log_message, 3, DEBUG_LOG_FILE);
}



?>