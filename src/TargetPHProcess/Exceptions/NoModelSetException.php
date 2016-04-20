<?php


namespace TargetPHProcess\Exceptions;


class NoModelSetException extends \Exception
{
    public function __construct() {
        $this->message = 'No model was set!';
    }
}