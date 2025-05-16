

<?php

include_once 'logging.php';

class View {
    private static $layout = 'admin';
    private static $data = [];

    private static function debug_log($message, $type = 'info') {
        if (!DEBUG_VIEW) return;
        
        $log_message = date('[Y-m-d H:i:s]') . " [VIEW] [{$type}] {$message}\n";
        error_log($log_message, 3, DEBUG_LOG_FILE);
    }

    public static function setLayout($layout) {
        self::$layout = $layout;
        debug_log("Layout set to: {$layout}");
    }

    public static function render($view, $data = []) {
        debug_log("Rendering view: {$view}");
        self::$data = array_merge(self::$data, $data);
        
        if (!empty($data)) {
            debug_log("View data: " . json_encode($data));
        }
        
        // Start output buffering
        ob_start();
        
        // Extract data to make variables available in view
        extract(self::$data);
        
        // Include the view file
        $viewFile = './frontend/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            debug_log("Loading view file: {$viewFile}");
            require_once $viewFile;
        } else {
            $error = "View file {$viewFile} not found";
            debug_log($error, 'error');
            throw new Exception($error);
        }
        
        // Get the view content
        $content = ob_get_clean();
        
        // Render the layout with the view content
        $layoutFile = './frontend/layouts/' . self::$layout . '.php';
        if (file_exists($layoutFile)) {
            debug_log("Loading layout: {$layoutFile}");
            require_once $layoutFile;
        } else {
            debug_log("No layout found, outputting raw content", 'warning');
            echo $content;
        }
    }

    public static function partial($partial, $data = []) {
        debug_log("Loading partial: {$partial}");
        if (!empty($data)) {
            debug_log("Partial data: " . json_encode($data));
        }
        
        extract($data);
        $partialFile = './frontend/components/' . $partial . '.php';
        if (file_exists($partialFile)) {
            debug_log("Including partial file: {$partialFile}");
            require_once $partialFile;
        } else {
            $error = "Partial {$partialFile} not found";
            debug_log($error, 'error');
            throw new Exception($error);
        }
    }

    public static function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}