<?php


namespace TargetPHProcess\Exceptions;


use Exception;

class NoSuitableConfigFileException extends Exception
{

    /**
     * NoSuitableConfigFileException constructor.
     * @param $currentDir
     */
    public function __construct($currentDir)
    {
        $this->message = "Project directory = {$currentDir}";
    }
}