<?php

function debug_log($message, $type = 'info')
{


    $file = debug_backtrace();
    $os = PHP_OS_FAMILY;
    if ($os === "Darwin") {
        $file = $file[0]['file'];
        $file = explode('/', $file);
        $file = $file[count($file) - 1];
        $file = explode('.php', $file)[0];
        $file = strtoupper($file);
    } else if ($os === "Windows") {
        $file = $file[0]['file'];
        $file = explode('\\', $file);
        $file = $file[count($file) - 1];
        $file = explode('.php', $file)[0];
        $file = strtoupper($file);
    }

    $log_message = date('[Y-m-d H:i:s]') . " [{$file}] [{$type}] {$message}\n";
    error_log($log_message, 3, DEBUG_LOG_FILE);
}




?>