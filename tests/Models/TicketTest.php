<?php


namespace Tests\Models\TPTable;


use TargetPHProcess\Models\Assignable;
use TargetPHProcess\Models\EntityState;
use TargetPHProcess\Models\Project;
use TargetPHProcess\Models\Release;
use TargetPHProcess\Models\Ticket;

class TicketTest extends \PHPUnit_Framework_TestCase
{
    private $assignable;
    /** @var Ticket */
    private $ticket;
    private $entityState;
    private $release;
    private $project;

    public function setUp()
    {
        $this->assignable = new Assignable();
        $this->assignable->Name = "Test Assignable";
        $this->assignable->Id = 12345;

        $this->entityState = new EntityState();
        $this->entityState->Name = "Ready";

        $this->release = new Release();
        $this->release->Name = "Release v1";
        
        $this->project = new Project();
        $this->project->Name = "HelloWorld";

        $this->assignable->EntityState = $this->entityState;
        $this->assignable->Release = $this->release;
        $this->assignable->Project = $this->project;
        $this->ticket = new Ticket($this->assignable);
    }

    /** @test */
    public function check_if_getters_are_okay()
    {
        $this->assertEquals('Test Assignable', $this->ticket->Name);
        $this->assertEquals(12345, $this->ticket->Id);
        $this->assertEquals('Ready', $this->ticket->EntityState);
        $this->assertEquals('Release v1', $this->ticket->Release);
        $this->assertEquals('HelloWorld', $this->ticket->Project);
        $this->assertEquals($this->assignable, $this->ticket->getAssignable());
    }


}