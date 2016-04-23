<?php


namespace TargetPHProcess\BLL\Auth;


class AuthGenerator
{
    public function generateBasicAuth($username, $password)
    {
        return base64_encode("{$username}:{$password}");
    }

    public function generateHeader($username, $password)
    {
        return "Authorization: Basic {$this->generateBasicAuth($username, $password)}";
    }
}