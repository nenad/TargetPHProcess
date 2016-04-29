<?php


namespace Tests\BLL\Console;


use TargetPHProcess\BLL\Console\TPDefinition;

class TPDefinitionTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function createInstance_checkIfTypeMatches()
    {
        $instance = new TPDefinition();
        $this->assertInstanceOf(TPDefinition::class, $instance);
    }
}
