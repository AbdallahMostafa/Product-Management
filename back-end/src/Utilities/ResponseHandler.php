<?php

namespace Src\Utilities;

class ResponseHandler
{
    public static function sendResponse($response)
    {
        $response->getCode();
        CorsUtility::setCorsHeaders();
        $headers = $response->getHeaders();
        foreach ($headers as $key => $value) {
            header($key . ': ' . $value);
        }
        http_response_code($response->getCode());
        
        echo $response->getBody();
        
    }   
}