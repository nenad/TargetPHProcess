<?php


namespace tests\DAL\Model;


use anlutro\cURL\cURL;
use JsonMapper;
use Mockery;
use TargetPHProcess\BLL\Configuration\Configuration;
use TargetPHProcess\DAL\Model\ProjectRepository;
use TargetPHProcess\Models\Project;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

class ProjectRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $curl;
    private $mapper;
    private $configuration;
    private $projectConfiguration;

    public function setUp()
    {
        $this->curl = Mockery::mock(cURL::class);
        $this->mapper = new JsonMapper();
        $this->configuration = Mockery::mock(Configuration::class);
        $this->projectConfiguration = new ProjectConfiguration();
        $this->projectConfiguration->tp_url = 'http://tp.url.com';
        $this->projectConfiguration->auth = 'basicauthhash';

        $this->configuration->shouldReceive('getProjectConfiguration')->once()->andReturn($this->projectConfiguration);
    }

    /** @test */
    public function checkIncludeAllIsCalled()
    {
        /** @var ProjectRepository $repo */
        $repo = \Mockery::mock(ProjectRepository::class . '[includeAll, get]',
            [$this->configuration, $this->curl, $this->mapper,]);
        $repo->shouldReceive('includeAll->get')->once();
        $repo->getAllProjects();
        $this->assertTrue(true); # Skip PHPUnit assertion warning
    }

    /** @test */
    public function checkGetAllProjectsIsCalled()
    {
        $project1 = new Project();
        $project1->Name = "Proj1";
        $project1->Id = 1;
        $project2 = new Project();
        $project2->Name = "Proj2";
        $project2->Id = 2;
        $projects[] = $project1;
        $projects[] = $project2;
        /** @var ProjectRepository $repo */
        $repo = \Mockery::mock(ProjectRepository::class . '[getAllProjects]',
            [$this->configuration, $this->curl, $this->mapper,]);
        $repo->shouldReceive('getAllProjects')->once()->andReturn($projects);
        $names = $repo->getAllProjectNames();
        $this->assertEquals(2, count($names));
        $this->assertEquals('Proj1 (1)', $names[0]);
        $this->assertEquals('Proj2 (2)', $names[1]);
    }
}
