<?php 

namespace App\Core;

use Exception;
class Route {
    protected static $routes = [
        'GET' => [],
        'POST' => [],
    ];

    protected static $nameRoutes = [];
    protected static $lastAddedRoute = null;

    public static function get($path, $handler) {
        $formattedPath = self::formatRoute($path);
        self::$routes['GET'][$formattedPath] = $handler;
        self::$lastAddedRoute = $formattedPath;
        return new static;
    }

    public static function post($path, $handler) {
        $formattedPath = self::formatRoute($path);
        self::$routes['POST'][$formattedPath] = $handler;
        self::$lastAddedRoute = $formattedPath;
        return new static;
    }

    public static function name($routeName) {
        if (self::$lastAddedRoute !== null) {
            self::$nameRoutes[$routeName] = self::$lastAddedRoute;
            self::$lastAddedRoute = null;
        } else {
            throw new Exception("No route available for named $routeName");
        }
        return new static;
    }

    public static function route($name, $params = []) {
        if (!isset(self::$nameRoutes[$name])) {
            throw new Exception("Route $name does not exist");
        }

        $route = self::$nameRoutes[$name];

        foreach ($params as $key => $value) {
            $route = str_replace('{' . $key . '}', $value, $route);
        }

        return $route;
    }

    protected static function formatRoute($route) {
        return '/' . trim($route, '/');
    }

public static function dispatch() {
    $method = $_SERVER['REQUEST_METHOD'];
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $cleanedRequest = self::formatRoute($requestUri);

    error_log("Request URI: " . $_SERVER['REQUEST_URI']);
    error_log("Cleaned Request: $cleanedRequest");

    $handler = self::match($method, $cleanedRequest);

    if ($handler) {
        error_log("Matched Route: " . print_r($handler, true));
        list($controller, $action) = explode('@', $handler['handler']);
        $params = $handler['params'];
        self::callAction($controller, $action, $params);
    } else {
        error_log("No route matched for: $cleanedRequest");
        http_response_code(404);
        self::error404();
    }
}

    protected static function error404() {
        $data = [
            'title' => '404 - Not Found',
            'message' => 'The page you are looking for could not be found',
        ];

        $viewPath = views_path('errors/404.php');

        if (!file_exists($viewPath)) {
            die("404 view file not found: $viewPath");
        }

        render('errors/404', $data, 'layouts/home');
    }

    public static function match($method, $requestUri) {
        foreach (self::$routes[$method] as $route => $handler) {
            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)}#', '(?P<$1>[a-zA-Z0-9_]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestUri, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
                return [
                    'handler' => $handler,
                    'params' => $params,
                ];
            }
        }
        return false;
    }

    protected static function callAction($controller, $action, $params = []) {
        $fullController = "App\\Controllers\\{$controller}";

        if (!class_exists($fullController)) {
            throw new Exception("Controller class not found: $fullController");
        }

        $controllerInstance = new $fullController();

        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("Action not found: $controller@$action");
        }

        call_user_func_array([$controllerInstance, $action], $params);
    }
}