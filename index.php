<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


require __DIR__ . '/vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['HomeController', 'index']);
    $r->addRoute('GET', '/diary[/]', ['PostController', 'index']);
    $r->addRoute('GET', '/diary/{post_name:[a-zA-Z0-9_-]+}[/]', ['PostController', 'PostIndex']);
   });

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        header("HTTP/1.0 405 Method Not Allowed");
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];


        [$controller, $method] = $handler;

    
        require __DIR__ . '/Controllers/' . $controller . '.php';
        
        $classController = new $controller();
        $classController->$method($vars);


        break;
    default:
        header("HTTP/1.0 500 Internal Server Error");
        echo '500 Internal Server Error';
}
?>