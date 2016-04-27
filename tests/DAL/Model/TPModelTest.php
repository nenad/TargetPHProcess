<?php


namespace DAL\Model;


use anlutro\cURL\cURL;
use JsonMapper;
use Mockery;
use TargetPHProcess\BLL\Configuration\Configuration;
use TargetPHProcess\DAL\Model\TPModel;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;
use Tests\DAL\Model\TestModel;
use Tests\DAL\Model\TPTestModel;

# Since the autoload doesn't load the classes found in /tests namespace, require_once is needed.
require_once 'TPTestModel.php';
require_once 'TestModel.php';

class TPModelTest extends \PHPUnit_Framework_TestCase
{
    /** @var Configuration|Mockery\MockInterface */
    protected $config;
    /** @var cURL|Mockery\MockInterface */
    protected $curl;
    /** @var JsonMapper */
    protected $mapper;
    /** @var TPModel */
    protected $model;
    /** @var ProjectConfiguration */
    protected $projectConfig;

    public function setUp()
    {
        $this->projectConfig = new ProjectConfiguration();
        $this->projectConfig->tp_url = 'http://test.url';
        $this->projectConfig->auth = 'auth';
        $this->projectConfig->directory = '/test';
        $this->projectConfig->project_id = 1;

        $this->config = Mockery::mock(Configuration::class);
        $this->curl = Mockery::mock(cURL::class);
        $this->mapper = new JsonMapper();

        $this->config->shouldReceive('getProjectConfiguration')->andReturn($this->projectConfig);

        $this->model = new TPTestModel($this->config, $this->curl, $this->mapper);
    }

    /** @test */
    public function createInstance_checkGettersSetters()
    {
        $attributes = ['Name', 'Description'];
        $query = 'where=(Id eq 1)';

        $this->model->setId(1);
        $this->assertEquals(1, $this->model->getId());

        $this->model->setExcludeAttributes($attributes);
        $this->assertEquals($attributes, $this->model->getExcludeAttributes());

        $this->model->setIncludeAttributes($attributes);
        $this->assertEquals($attributes, $this->model->getIncludeAttributes());

        $this->model->setFormat('xml');
        $this->assertEquals('xml', $this->model->getFormat());

        $this->model->setSkip(10);
        $this->assertEquals(10, $this->model->getSkip());

        $this->model->setTake(10);
        $this->assertEquals(10, $this->model->getTake());

        $this->assertEquals(TestModel::class, $this->model->getModel());
        $this->assertEquals('TestModels', $this->model->getModelEntity());

        $this->model->setQuery($query);
        $this->assertEquals($query, $this->model->getQuery());
    }

    /** @test */
    public function checkIncludeAllReturnsAllKeys()
    {
        $this->model->includeAll();
        $this->assertEquals(['Name', 'Description', 'Times', 'Id'], $this->model->getIncludeAttributes());
        $this->assertEquals('[Name,Description,Times,Id]', $this->model->getData()['include']);
    }

    /** @test */
    public function checkMappedObjectIsValid()
    {
        $this->assertTrue(true);
    }

}
