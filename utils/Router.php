<?php
include_once 'logging.php';

class Router
{
    private $routes = [];
    public function addRoute($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
        debug_log("Route added: {$method} {$path}");
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = isset($_GET['url']) ? '/' . trim($_GET['url'], '/') : '/';

        debug_log("Handling request: {$method} {$url}");
        if (!isset($_SESSION["user"])) {
            View::render('generic/login');
        }
        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                $params = $this->matchPath($route['path'], $url);
                if ($params !== false) {
                    debug_log("Route matched: {$route['method']} {$route['path']}");
                    return call_user_func($route['callback'], $params);
                }
            }
        }

        debug_log("No matching route found for: {$method} {$url}", 'warning');
        http_response_code(404);
        require_once './frontend/404.php';
    }

    private function matchPath($routePath, $requestPath)
    {
        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestPath, '/'));

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        $params = [];
        for ($i = 0; $i < count($routeParts); $i++) {
            if (strpos($routeParts[$i], ':') === 0) {
                $paramName = substr($routeParts[$i], 1);
                $params[$paramName] = $requestParts[$i];
            } elseif ($routeParts[$i] !== $requestParts[$i]) {
                return false;
            }
        }
        debug_log("Route parameters: " . json_encode($params));
        return !empty($params) ? $params : ($routePath === $requestPath);
    }
}