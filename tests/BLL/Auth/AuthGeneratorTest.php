<?php


namespace TargetPHProcess\BLL\Auth;


class AuthGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var AuthGenerator */
    private $authGenerator;

    public function setUp()
    {
        $this->authGenerator = new AuthGenerator();
    }

    /** @test */
    public function generate_basic_auth_header()
    {
        $username = 'username';
        $password = 'password';
        $actualHeader = $this->authGenerator->generateHeader($username, $password);
        $expectedHeader = "Authorization: Basic " . base64_encode($username . ':' . $password);

        $this->assertEquals($expectedHeader, $actualHeader);
    }
}
