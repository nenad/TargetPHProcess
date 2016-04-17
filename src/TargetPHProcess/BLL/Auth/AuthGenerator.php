<?php


namespace TargetPHProcess\BLL\Auth;


class AuthGenerator
{
    public function generateHeader($username, $password)
    {
        return "Authorization: Basic " . base64_encode($username . ':' . $password);
    }
}