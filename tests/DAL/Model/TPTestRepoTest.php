<?php


namespace Tests\DAL\Model;


use anlutro\cURL\cURL;
use anlutro\cURL\Request;
use anlutro\cURL\Response;
use JsonMapper;
use Mockery;
use TargetPHProcess\BLL\Configuration\Configuration;
use TargetPHProcess\DAL\Model\TPModel;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

class TPTestRepoTest extends \PHPUnit_Framework_TestCase
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

        $this->model = new TPTestRepo($this->config, $this->curl, $this->mapper);
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

        $config = new ProjectConfiguration();
        $this->model->setConfiguration($config);
        $this->assertEquals($config, $this->model->getConfiguration());
        $this->assertTrue($this->model->hasConfiguration());

        $this->assertEquals(TestModel::class, $this->model->getModel());
        $this->assertEquals('TestModels', $this->model->getModelEntity());

        $this->model->setQuery($query);
        $this->assertEquals($query, $this->model->getQuery());
    }

    /** @test */
    public function checkIncludeAllReturnsAllKeys()
    {
        $this->model->includeAll();
        $this->assertEquals(['Name', 'Description', 'TestModelArrays', 'Id'], $this->model->getIncludeAttributes());
        $this->assertEquals('[Name,Description,TestModelArrays,Id]', $this->model->getData()['include']);
    }

    /** @test */
    public function checkExcludeKeys()
    {
        $this->model->addExcludeAttributes(['Description', 'Times']);
        $this->assertEquals(['Description', 'Times'], $this->model->getExcludeAttributes());
        $this->assertEquals('[Description,Times]', $this->model->getData()['exclude']);
    }

    /** @test */
    public function checkRecursiveWrapperIsOkay()
    {
        $this->model->includeAll();
        $this->model->addIncludeAttributes(['TestModelArrays' => ['Id', 'Name']]);

        $this->assertEquals('[Name,Description,TestModelArrays,Id,TestModelArrays[Id,Name]]',
            $this->model->getData()['include']);
    }

    /** @test */
    public function checkWrapperIsOkay()
    {
        $this->model->includeAll();
        $this->assertEquals('[Name,Description,TestModelArrays,Id]', $this->model->getData()['include']);
    }

    /** @test */
    public function runGetQuerySingleResult()
    {
        $data = '{"Id":"1"}';
        $this->config->shouldReceive('getProjectConfiguration')->andReturn($this->projectConfig);
        $model = new TPTestRepo($this->config, $this->curl, $this->mapper);
        $expectedUrl = $this->projectConfig->tp_url . '/api/v1/TestModels';

        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);
        $response->body = $data;
        $response->statusCode = 200;
        $this->curl->shouldReceive('newRequest')
            ->with('GET', $expectedUrl)
            ->andReturn($request)
            ->once();
        $this->curl->shouldReceive('buildUrl')->once()->andReturn($expectedUrl);
        $request->shouldReceive('setHeader')
            ->with('Authorization', "Basic {$this->projectConfig->auth}")
            ->once();
        $request->shouldReceive('send')->andReturn($response)->once();

        $object = $model->get();
        $this->assertInstanceOf(TestModel::class, $object);
    }

    /** @test */
    public function runGetQueryArrayResult()
    {
        $data = '{"Items": [{"Id":"1"},{"Id":"2"}]}';
        $this->config->shouldReceive('getProjectConfiguration')->andReturn($this->projectConfig);
        $model = new TPTestRepo($this->config, $this->curl, $this->mapper);
        $expectedUrl = $this->projectConfig->tp_url . '/api/v1/TestModels';

        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);
        $response->body = $data;
        $response->statusCode = 200;
        $this->curl->shouldReceive('newRequest')
            ->with('GET', $expectedUrl)
            ->andReturn($request)
            ->once();
        $this->curl->shouldReceive('buildUrl')->once()->andReturn($expectedUrl);
        $request->shouldReceive('setHeader')
            ->with('Authorization', "Basic {$this->projectConfig->auth}")
            ->once();
        $request->shouldReceive('send')->andReturn($response)->once();

        $arrayObject = $model->get();
        $this->assertInternalType('array', $arrayObject);
        foreach ($arrayObject as $object) {
            $this->assertInstanceOf(TestModel::class, $object);
        }
    }

    /**
     * @test
     * @expectedException \TargetPHProcess\Exceptions\BadResponseException
     */
    public function runGetQueryThrowException()
    {
        $data = '{"Items": [{"Id":"1"},{"Id":"2"}]}';
        $this->config->shouldReceive('getProjectConfiguration')->andReturn($this->projectConfig);
        $model = new TPTestRepo($this->config, $this->curl, $this->mapper);
        $expectedUrl = $this->projectConfig->tp_url . '/api/v1/TestModels';

        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);
        $response->body = $data;
        $response->statusCode = 403;
        $this->curl->shouldReceive('newRequest')
            ->with('GET', $expectedUrl)
            ->andReturn($request)
            ->once();
        $this->curl->shouldReceive('buildUrl')->once()->andReturn($expectedUrl);
        $request->shouldReceive('setHeader')
            ->with('Authorization', "Basic {$this->projectConfig->auth}")
            ->once();
        $request->shouldReceive('send')->andReturn($response)->once();

        $arrayObject = $model->get();
    }

    /** @test */
    public function runPostQuery()
    {
        $data = '{"Id":"1"}';
        $this->config->shouldReceive('getProjectConfiguration')->andReturn($this->projectConfig);
        $model = new TPTestRepo($this->config, $this->curl, $this->mapper);
        $model->setPostData($data);
        $model->setId(1);
        $expectedUrl = $this->projectConfig->tp_url . '/api/v1/TestModels/1';

        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);
        $response->body = $data;
        $response->statusCode = 200;
        $this->curl->shouldReceive('newRequest')
            ->with('POST', $expectedUrl, $data, Request::ENCODING_RAW)
            ->andReturn($request)->once();
        $this->curl->shouldReceive('buildUrl')->once()->andReturn($expectedUrl);
        $request->shouldReceive('setHeader')
            ->with('Authorization', "Basic {$this->projectConfig->auth}")->once();
        $request->shouldReceive('setHeader')
            ->with('Content-Type', "application/json")->once();
        $request->shouldReceive('send')->andReturn($response)->once();

        $object = $model->post();
        $this->assertInstanceOf(TestModel::class, $object);
    }

    /**
     * @test
     * @expectedException \TargetPHProcess\Exceptions\BadResponseException
     */
    public function runPostQueryThrowException()
    {
        $data = '{"Id":"1"}';
        $this->config->shouldReceive('getProjectConfiguration')->andReturn($this->projectConfig);
        $model = new TPTestRepo($this->config, $this->curl, $this->mapper);
        $model->setPostData($data);
        $model->setId(1);
        $expectedUrl = $this->projectConfig->tp_url . '/api/v1/TestModels/1';

        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);
        $response->body = $data;
        $response->statusCode = 400;
        $this->curl->shouldReceive('newRequest')
            ->with('POST', $expectedUrl, $data, Request::ENCODING_RAW)
            ->andReturn($request)->once();
        $this->curl->shouldReceive('buildUrl')->once()->andReturn($expectedUrl);
        $request->shouldReceive('setHeader')
            ->with('Authorization', "Basic {$this->projectConfig->auth}")->once();
        $request->shouldReceive('setHeader')
            ->with('Content-Type', "application/json")->once();
        $request->shouldReceive('send')->andReturn($response)->once();

        $object = $model->post();
    }

    /** @test */
    public function checkFindReturnsObject()
    {
        $data = '{"Id": "1"}';
        $this->model->setId(1);
        $expectedUrl = $this->projectConfig->tp_url . '/api/v1/TestModels/1';
        $this->curl->shouldReceive('buildUrl')->once()->andReturn($expectedUrl);
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);
        $response->body = $data;
        $response->statusCode = 200;
        $this->curl->shouldReceive('newRequest')
            ->with('GET', $expectedUrl)
            ->andReturn($request)
            ->once();
        $request->shouldReceive('setHeader')
            ->with('Authorization', "Basic {$this->projectConfig->auth}")->once();
        $request->shouldReceive('send')->andReturn($response)->once();

        $object = $this->model->find(1);
        $this->assertInstanceOf(TestModel::class, $object);
    }

    /** @test */
    public function checkGetAllReturnsCollection()
    {
        $data = '{"Items": [{"Id": "1"},{"Id": "2"}]}';
        $expectedUrl = $this->projectConfig->tp_url . '/api/v1/TestModels';
        $this->curl->shouldReceive('buildUrl')->once()->andReturn($expectedUrl);
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);
        $response->body = $data;
        $response->statusCode = 200;
        $this->curl->shouldReceive('newRequest')
            ->with('GET', $expectedUrl)
            ->andReturn($request)
            ->once();
        $request->shouldReceive('setHeader')
            ->with('Authorization', "Basic {$this->projectConfig->auth}")->once();
        $request->shouldReceive('send')->andReturn($response)->once();

        $arrayObject = $this->model->all();
        $this->assertInternalType('array', $arrayObject);
        foreach ($arrayObject as $object) {
            $this->assertInstanceOf(TestModel::class, $object);
        }
    }

    /**
     * @test
     * @expectedException \TargetPHProcess\Exceptions\NoModelSetException
     */
    public function checkIfNotSetModelThrowsException()
    {
        $model = new TPModel($this->config, $this->curl, $this->mapper);
        $model->get();
    }

    /** @test */
    public function checkReturnedObjectHasArrayAsKey()
    {
        $data = '{"Id": "1", "TestModelArrays": {"Items": [{"Id":"1"}]}}';
        $this->model->setId(1);
        $expectedUrl = $this->projectConfig->tp_url . '/api/v1/TestModels/1';
        $this->curl->shouldReceive('buildUrl')->once()->andReturn($expectedUrl);
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);
        $response->body = $data;
        $response->statusCode = 200;
        $this->curl->shouldReceive('newRequest')
            ->with('GET', $expectedUrl)
            ->andReturn($request)
            ->once();
        $request->shouldReceive('setHeader')
            ->with('Authorization', "Basic {$this->projectConfig->auth}")->once();
        $request->shouldReceive('send')->andReturn($response)->once();

        /** @var TestModel $object */
        $object = $this->model->find(1);
        $this->assertInstanceOf(TestModel::class, $object);
        $this->assertNotEmpty($object->TestModelArrays);
    }

}
