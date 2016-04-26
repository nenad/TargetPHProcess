<?php


namespace TargetPHProcess\Exceptions;


use anlutro\cURL\Response;
use Exception;

class BadResponseException extends Exception
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
        $this->message = "Bad response. Code: {$response->statusCode}. Message: {$response->body}";
    }
}