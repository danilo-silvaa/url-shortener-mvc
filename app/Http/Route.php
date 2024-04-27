<?php 

namespace App\Http;

class Route 
{
    private static array $routes = [];

    public static function get(string $path, string $action)
    {
        self::$routes[] = [
            'path'   => $path,
            'action' => $action,
            'method' => 'GET'
        ];
    }

    public static function post(string $path, string $action)
    {
        self::$routes[] = [
            'path'   => $path,
            'action' => $action,
            'method' => 'POST'
        ];
    }

    public static function put(string $path, string $action)
    {
        self::$routes[] = [
            'path'   => $path,
            'action' => $action,
            'method' => 'PUT'
        ];
    }

    public static function delete(string $path, string $action)
    {
        self::$routes[] = [
            'path'   => $path,
            'action' => $action,
            'method' => 'DELETE'
        ];
    }

    public static function routes()
    {
        return self::$routes;
    }

    public static function dispatch()
    {
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        $method = $_SERVER['REQUEST_METHOD'];
    
        $routeFound = false;

        foreach (self::$routes as $route) {
            $pattern = '#^' . preg_replace('/{id}/', '([\w-]+)', $route['path']) . '$#';

            if ($route['method'] === $method && preg_match($pattern, $url, $matches)) {
                array_shift($matches);
    
                $routeFound = true;
    
                [$controller, $action] = explode('@', $route['action']);
    
                $controller = 'App\\Controllers\\' . $controller;
                $extendController = new $controller();
                $extendController->$action(new Request, new Response, $matches);
    
                return;
            }
        }
    
        if (!$routeFound) {
            $controller = 'App\\Controllers\\NotFoundController';
            $extendController = new $controller();
            $extendController->index(new Request, new Response);
        }
    }    
}