<?php


namespace Tests\DAL\Model;


use anlutro\cURL\cURL;
use anlutro\cURL\Request;
use anlutro\cURL\Response;
use JsonMapper;
use Mockery;
use TargetPHProcess\BLL\Configuration\Configuration;
use TargetPHProcess\DAL\Model\TimeRepository;
use TargetPHProcess\Models\Time;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

class TimeRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Mockery\MockInterface */
    private $curl;
    /** @var Mockery\MockInterface */
    private $mapper;
    /** @var Mockery\MockInterface */
    private $configuration;
    /** @var TimeRepository * */
    private $repo;
    /** @var ProjectConfiguration */
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
        $this->repo = new TimeRepository($this->configuration, $this->curl, $this->mapper);
    }

    /** @test */
    public function callCreate()
    {
        $time = new Time();
        $time->Id = 1;

        $jsonData = json_encode($time->getTPObject());
        $expectedUrl = $this->projectConfiguration->tp_url . '/api/v1/Times';
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);
        $response->body = '{"Id": 1, "Description": "DemoTime"}';

        $this->curl->shouldReceive('buildUrl')->with($expectedUrl,
            ['format' => 'json'])->once()->andReturn($expectedUrl);
        $this->curl->shouldReceive('newRequest')
            ->with('POST', $expectedUrl, $jsonData, Request::ENCODING_RAW)
            ->andReturn($request)->once();
        $request->shouldReceive('setHeader')->with('Authorization',
            "Basic {$this->projectConfiguration->auth}")->once();
        $request->shouldReceive('setHeader')->with('Content-Type', "application/json")->once();
        $request->shouldReceive('send')->once()->andReturn($response);


        $time = $this->repo->create($time);

        $this->assertEquals($this->repo->getFormat(), 'json');
        $this->assertEquals($this->repo->getPostData(), $jsonData);
        $this->assertInstanceOf(Time::class, $time);
        $this->assertEquals(1, $time->Id);
        $this->assertEquals('DemoTime', $time->Description);
    }
}
