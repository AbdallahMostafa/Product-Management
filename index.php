<?php
use Src\Interfaces\JSONResponseInterface;
use Src\Utilities\CorsUtility;
use Src\Utilities\ResponseHandler;
use Src\Controllers\Helpers\JSONResponse;

require_once __DIR__ . '/vendor/autoload.php';

// Get the requested URI and HTTP method
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Handle Pre Flight Request 
if ($requestMethod === 'OPTIONS') {
    CorsUtility::handlePreflightRequest();
    exit;
} 
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

    $requestBody = [];
    if ($requestMethod === 'POST' || $requestMethod === 'DELETE') {
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
    
    try {
        $response = call_user_func($handler, $requestBody);
        if (!($response instanceof JSONResponseInterface)) {
            throw new Exception("Undefined Error", 500);
        }
        
    } catch (\Exception $e) {
        $response = new JSONResponse($e->getMessage(),$e->getCode() ?? 500);
        
    }
} else {
    // No matching route found
    $response = new JSONResponse(['error' => 'Endpoint not found'], 404, ['HTTP/1.0 404 Not Found']);
   
}
ResponseHandler::sendResponse($response);
