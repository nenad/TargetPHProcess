<?php


namespace SystemConfiguration;


use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use TargetPHProcess\SystemConfiguration\ConfigurationWriter;

class ConfigurationWriterTest extends \PHPUnit_Framework_TestCase
{
    /** @var vfsStreamDirectory */
    protected $root;

    public function setUp()
    {
        $this->root = vfsStream::setup('/', 755, ['home' => ['test']]);
        $_SERVER['HOME'] = vfsStream::url('/home/test');
        mkdir($_SERVER['HOME']);
    }

    /** @test */
    public function checkIfConfigFileIsCreated()
    {
        $instance = new ConfigurationWriter();
        $this->assertTrue($this->root->hasChild('/home/test/.tpconfig'));
        $json = file_get_contents(vfsStream::url('/home/test/.tpconfig'));
        $this->assertEquals('[]', $json);
    }
}
