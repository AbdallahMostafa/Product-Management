<?php

require_once __DIR__ . '/vendor/autoload.php';

// Get the requested URI and HTTP method
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Include the routes
$routes = require_once __DIR__ . '/src/Routes/routes.php';
$container = $GLOBALS['container'];
// Find a matching route
$matchedRoute = null;
foreach ($routes as $route) {
    [$method, $pattern, $handler] = $route;
    if ($method === $requestMethod && $pattern === $requestUri) {
        $matchedRoute = $route;
        break;
    }
}

// If a matching route is found, handle the request
if ($matchedRoute !== null) {
    $handler = $matchedRoute[2];

    // Call the handler method or function
    // Search Here to bypass the static fucntion calls

    $requestBody = [];
    if ($requestMethod === 'POST') {
        // Check if the request is JSON
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') === 0) {
            // Get the JSON payload
            $requestPayload = file_get_contents('php://input');
            $requestBody = json_decode($requestPayload, true);
        } else {
            // Assume form data
            $requestBody = $_POST;
        }
    }

    call_user_func($handler, $requestBody);
} else {
    // No matching route found
    header('HTTP/1.0 404 Not Found');
    echo json_encode(['error' => 'Endpoint not found']);
}
