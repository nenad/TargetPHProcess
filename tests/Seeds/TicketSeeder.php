<?php


namespace Tests\Seeds;


use Faker\Factory;
use TargetPHProcess\Models\Assignable;
use TargetPHProcess\Models\EntityState;
use TargetPHProcess\Models\Project;
use TargetPHProcess\Models\Release;
use TargetPHProcess\Models\Ticket;

class TicketSeeder
{
    private $projectNumber;
    private $releaseNumber;

    /** @var \Faker\Generator */
    private $faker;
    /** @var array */
    private $projects;
    /** @var array */
    private $releases;
    private $states = ['Ready', 'In Progress', 'In Testing'];

    public function __construct($projectNumber = 1, $releaseNumber = 1)
    {
        $this->projectNumber = $projectNumber;
        $this->releaseNumber = $releaseNumber;
        $this->faker = Factory::create();
        $this->generateBootstrap();
    }

    private function generateBootstrap()
    {
        for ($i = 0; $i < $this->projectNumber; $i++) {
            $project = new Project();
            $project->Name = $this->faker->domainName;
            $project->Id = $this->faker->numberBetween(1, 1000);
            $this->projects[] = $project;
        }
        for ($i = 0; $i < $this->releaseNumber; $i++) {
            $release = new Release();
            $release->Name = $this->faker->colorName;
            $release->Id = $this->faker->numberBetween(1, 1000);
            $this->releases[] = $release;
        }
    }

    public function getTickets($number)
    {
        $tickets = [];
        for ($i = 0; $i < $number; $i++) {
            $state = new EntityState();
            $state->Name = $this->states[mt_rand(0, count($this->states) - 1)];
            $assignable = new Assignable();
            $assignable->Id = $this->faker->numberBetween(1, 100000);
            $assignable->Name = $this->faker->sentences(4);
            $assignable->Project = $this->projects[mt_rand(0, $this->projectNumber - 1)];
            $assignable->Release = $this->releases[mt_rand(0, $this->releaseNumber - 1)];
            $assignable->EntityState = $state;
            $tickets[] = new Ticket($assignable);
        }
        return $tickets;
    }

    public function createTicket($xAxis, $xData, $yAxis, $yData)
    {
        $state = new EntityState();
        $state->Name = $this->states[mt_rand(0, count($this->states) - 1)];
        $assignable = new Assignable();
        $assignable->Id = $this->faker->numberBetween(1, 100000);
        $assignable->Name = $this->faker->sentences(4);
        $assignable->Project = $this->projects[mt_rand(0, $this->projectNumber - 1)];
        $assignable->Release = $this->releases[mt_rand(0, $this->releaseNumber - 1)];
        $assignable->EntityState = $state;
        
        $ticket = new Ticket($assignable);
        $ticket->Id = $this->faker->numberBetween(1, 100000);
        $ticket->Name = $this->faker->sentences(4);
        $ticket->{$xAxis} = $xData;
        $ticket->{$yAxis} = $yData;
        return $ticket;
    }
}