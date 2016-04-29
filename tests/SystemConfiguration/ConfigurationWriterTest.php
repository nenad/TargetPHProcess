<?php


namespace Tests\SystemConfiguration;


use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use TargetPHProcess\SystemConfiguration\ConfigurationWriter;

class ConfigurationWriterTest extends \PHPUnit_Framework_TestCase
{
    /** @var vfsStreamDirectory */
    protected $root;

    /** @var ConfigurationWriter */
    private $instance;

    public function setUp()
    {
        $this->root = vfsStream::setup('test');
        $_SERVER['HOME'] = vfsStream::url('test');
        $this->instance = new ConfigurationWriter();
    }

    /** @test */
    public function checkIfConfigFileIsCreated()
    {
        $this->assertTrue($this->root->hasChild('test/.tpconfig'));
        $json = file_get_contents(vfsStream::url('test/.tpconfig'));
        $this->assertEquals('[]', $json);
    }

    /** @test */
    public function checkIfWriteReadIsSuccess()
    {
        $json = '{"Id":"1"}';
        $this->instance->writeConfig($json);
        $readJson = $this->instance->readConfig();
        $this->assertJson($json);
        $this->assertEquals($json, $readJson);
    }
}
