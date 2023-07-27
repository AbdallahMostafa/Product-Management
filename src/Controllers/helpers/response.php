<?php

function setCorsHeaders() {
    header('Access-Control-Allow-Origin: http://localhost:3000'); 
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    // header('Access-Control-Allow-Credentials: true'); // Add this if you need to include credentials
}

// Check if the request is a preflight request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    setCorsHeaders();
    exit; // Respond to the preflight request and stop further execution
}

// Add CORS headers for other requests
setCorsHeaders();

// Function to send a JSON response
function jsonResponse($data, $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}