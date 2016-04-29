<?php


namespace Tests\BLL\Configuration;


use JsonMapper;
use Mockery;
use TargetPHProcess\BLL\Configuration\Configuration;
use TargetPHProcess\SystemConfiguration\ConfigurationWriter;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /** @var Mockery\MockInterface */
    protected $configWriter;
    protected $mapper;

    public function setUp()
    {
        $this->configWriter = Mockery::mock(ConfigurationWriter::class);
        $this->mapper = new JsonMapper();
    }

    /** @test */
    public function createInstance_checkIfConfigIsLoaded()
    {
        $configJson = "[{\"directory\":\"\/demo\/dir\",\"project_id\":99,\"auth\":\"zouLFRldG92ZWMx\",\"tp_url\":\"http:\/\/tp.test.com\"}]";
        $this->configWriter->shouldReceive('readConfig')->andReturn($configJson);
        $instance = new Configuration($this->configWriter, $this->mapper);
        $this->assertTrue(Configuration::$isLoaded);
    }

    /** @test */
    public function createProject_checkIfProjectIsValid()
    {
        $configJson = "[{\"directory\":\"\/demo\/dir\",\"project_id\":99,\"auth\":\"auth\",\"tp_url\":\"http:\/\/tp.test.com\"}]";
        $this->configWriter->shouldReceive('readConfig')->andReturn($configJson);
        $instance = new Configuration($this->configWriter, $this->mapper);
        $allProjects = $instance->getAllProjectConfigurations();
        $this->assertEquals(1, count($allProjects));
        $project = $allProjects[0];
        $this->assertInstanceOf(ProjectConfiguration::class, $project);
        $this->assertEquals('/demo/dir', $project->directory);
        $this->assertEquals('99', $project->project_id);
        $this->assertEquals('auth', $project->auth);
        $this->assertEquals('http://tp.test.com', $project->tp_url);
    }

    /** @test */
    public function createConfiguration_addAndSaveConfig()
    {
        $configJson = "[{\"directory\":\"\/demo\/dir\",\"project_id\":99,\"auth\":\"auth\",\"tp_url\":\"http:\/\/tp.test.com\"}]";
        $newProject = new ProjectConfiguration();
        $newProject->tp_url = 'http://tp.new.com';
        $newProject->auth = 'auth2';
        $newProject->directory = '/demo/dir2';
        $newProject->project_id = 2;

        $this->configWriter->shouldReceive('readConfig')->andReturn($configJson);

        $instance = new Configuration($this->configWriter, $this->mapper);
        $instance->addConfig($newProject);
        $allProjects = $instance->getAllProjectConfigurations();
        $this->assertEquals(2, count($allProjects));
        $this->configWriter->shouldReceive('writeConfig')->with(json_encode($allProjects));
        $instance->saveConfig();
    }

    /** @test */
    public function checkCorrectConfigIsReturned()
    {
        $configJson = "[{\"directory\":\"\/demo\/dir\",\"project_id\":99,\"auth\":\"auth\",\"tp_url\":\"http:\/\/tp.test.com\"}]";
        $this->configWriter->shouldReceive('readConfig')->andReturn($configJson);
        $instance = new Configuration($this->configWriter, $this->mapper);
        $_SERVER['PWD'] = '/demo/dir';
        $projectConfig = $instance->getProjectConfiguration();
        $this->assertInstanceOf(ProjectConfiguration::class, $projectConfig);
    }

    /** @test */
    public function checkNoProjectIsReturned()
    {
        $configJson = "[{\"directory\":\"\/demo\/dir\",\"project_id\":99,\"auth\":\"auth\",\"tp_url\":\"http:\/\/tp.test.com\"}]";
        $this->configWriter->shouldReceive('readConfig')->andReturn($configJson);
        $instance = new Configuration($this->configWriter, $this->mapper);
        $_SERVER['PWD'] = '/demo/noexist';
        $projectConfig = $instance->getProjectConfiguration();
        $this->assertNull($projectConfig);
    }

    /** @test */
    public function overwriteConfig()
    {
        $configJson = "[{\"directory\":\"\/demo\/dir\",\"project_id\":99,\"auth\":\"auth\",\"tp_url\":\"http:\/\/tp.test.com\"}]";
        $newProject = new ProjectConfiguration();
        $newProject->tp_url = 'http://tp.new.com';
        $newProject->auth = 'auth2';
        $newProject->directory = '/demo/dir';
        $newProject->project_id = 2;

        $this->configWriter->shouldReceive('readConfig')->andReturn($configJson);
        $instance = new Configuration($this->configWriter, $this->mapper);
        $instance->addConfig($newProject);
        $allProjects = $instance->getAllProjectConfigurations();
        $this->assertEquals(1, count($allProjects));
        $projectConfig = $allProjects[0];
        $this->assertEquals('auth2', $projectConfig->auth);
        $this->assertEquals(2, $projectConfig->project_id);
        
        $this->configWriter->shouldReceive('writeConfig')->with(json_encode($allProjects));
        $instance->saveConfig();
    }

    public function tearDown()
    {
        Configuration::$isLoaded = false;
    }

}
