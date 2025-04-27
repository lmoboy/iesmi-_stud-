<?php
function debug_log($message, $type = 'info')
{
    if (!DEBUG_MODE)
        return;

    $file = debug_backtrace();
    $os = PHP_OS_FAMILY;
    $file = $file[0]['file'];
    if ($os == "Windows")
        $file = explode('\\', $file);
    else
        $file = explode('/', $file);
    $file = $file[count(value: $file) - 1];
    $file = explode('.php', $file)[0];
    $file = strtoupper($file);


    $log_message = date('[Y-m-d H:i:s]') . " [{$file}] [{$type}] {$message}\n";
    error_log($log_message, 3, DEBUG_LOG_FILE);
}
?>