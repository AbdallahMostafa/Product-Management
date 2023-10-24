<?php

namespace Src\Utilities;


class CorsUtility
{
    /**
     * Set CORS headers to allow cross-origin requests.
     */
    public static function setCorsHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        http_response_code(204);
    }

    /**
     * Check if the request is a preflight request (OPTIONS).
     */
    public static function handlePreflightRequest()
    {
        self::setCorsHeaders();
        exit; // Respond to the preflight request and stop further execution
    }
}
