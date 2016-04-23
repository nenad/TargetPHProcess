<?php

namespace TargetPHProcess\Models;

use PHPUnit_Framework_TestCase;

class AssignableTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function fillIdAndObject_getJsonData_checkIsValid()
    {

        $entityState = new EntityState();
        $entityState->Id = 2;
        $entityState->Name = 'In Progress';

        $project = new Project();
        $project->Id = 1;
        $project->Name = 'ProjectName';
        $project->Description = 'ProjectDescription';
        $project->EntityState = $entityState;

        $assignable = new Assignable();
        $assignable->Id = 3;
        $assignable->Name = 'AssignableName';
        $assignable->Project = $project;

        $actualData = json_encode($assignable->getJsonData());

        $expectedData = '{"Name":"AssignableName","Project":{"Name":"ProjectName","Description":"ProjectDescription","EntityState":{"Name":"In Progress","Id":2},"Id":1},"Id":3}';
        $this->assertJson($actualData);
        $this->assertEquals($expectedData, $actualData);
    }
}