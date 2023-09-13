<?php

namespace Src\Controllers\Helpers;

use Src\Interfaces\JSONResponseInterface;
class JSONResponse implements JSONResponseInterface
{
    private $statusCode;
    private $data;

    private $headers;

    public function __construct($data, $statusCode = 200, $headers = [] )
    {
        $this->headers = array_merge(['Content-Type' => 'application/json'], $headers); 
        $this->statusCode = $statusCode;
        $this->data = json_encode($data);
    }
    public function getHeaders()
    {
        return $this->headers;
    }
    public function getCode()
    {
        return $this->statusCode;
    }
    public function getBody()
    {
        return $this->data;
    }
}


