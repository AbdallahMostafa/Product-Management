<?php

namespace Src\Interfaces;

/**
 * JSONResponseInterface represents an interface for JSON responses.
 */
interface JSONResponseInterface
{
    /**
     * Get the response body.
     *
     * @return array|object The response body, which can be an array or an object.
     */
    function getBody();
    /**
     * Get the HTTP status code of the response.
     *
     * @return int The HTTP status code.
     */
    function getCode();
    /**
     * Get an array of HTTP headers associated with the response.
     *
     * @return array The HTTP headers.
     */
    function getHeaders();
}