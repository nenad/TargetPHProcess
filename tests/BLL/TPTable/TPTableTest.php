<?php


namespace Tests\BLL\TPTable;


use TargetPHProcess\BLL\TPTable\TPTable;
use TargetPHProcess\Models\Ticket;
use Tests\Seeds\TicketSeeder;

class TPTableTest extends \PHPUnit_Framework_TestCase
{
    /** @var TPTable */
    private $table;
    /** @var TicketSeeder */
    private $seeder;

    public function setUp()
    {
        /** @var Ticket[] $tickets */
        $tickets = [];
        $this->table = new TPTable('EntityState', 'Release', $tickets);
        $this->seeder = new TicketSeeder(1, 1);
    }

    /** @test */
    public function checkCountCorrect()
    {
        $tickets = $this->seeder->getTickets(5);
        $this->table = new TPTable('EntityState', 'Release', $tickets);
        $this->assertEquals(5, $this->table->getTicketCount());
    }

    /** @test */
    public function checkCorrectTableOrdering()
    {
        $tickets = $this->getTickets();
        $this->table = new TPTable('Release', 'EntityState', $tickets);
        $this->assertEquals(2, count($this->table->getTicketsFromAxis('v1', 'Ready')));
        $this->assertEquals(2, count($this->table->getTicketsFromAxis('v1', 'In Testing')));
        $this->assertEquals(2, count($this->table->getTicketsFromAxis('v2', 'Ready')));
        $this->assertEquals(2, count($this->table->getTicketsFromAxis('v2', 'In Testing')));
    }

    /** @test */
    public function checkEmptyAxisTableOrdering()
    {
        $tickets = [];
        $tickets[] = $this->seeder->createTicket('Release', 'v1', 'EntityState', 'Ready');
        $this->table = new TPTable('Release', 'EntityState', $tickets);
        $this->assertEmpty($this->table->getTicketsFromAxis('v2', 'Ready'));
    }

    /** @test */
    public function checkXAxis()
    {
        $tickets = $this->getTickets();
        $this->table = new TPTable('Release', 'EntityState', $tickets);
        $this->assertNotEmpty($this->table->getTicketsFromXAxis('v2'));
        $this->assertEquals(4, count($this->table->getTicketsFromXAxis('v2')));
    }

    /** @test */
    public function checkYAxis()
    {
        $tickets = $this->getTickets();
        $this->table = new TPTable('Release', 'EntityState', $tickets);
        $this->assertNotEmpty($this->table->getTicketsFromYAxis('Ready'));
        $this->assertEquals(4, count($this->table->getTicketsFromYAxis('Ready')));
    }

    private function getTickets()
    {
        $tickets = [];
        $tickets[] = $this->seeder->createTicket('Release', 'v1', 'EntityState', 'Ready');
        $tickets[] = $this->seeder->createTicket('Release', 'v1', 'EntityState', 'In Testing');
        $tickets[] = $this->seeder->createTicket('Release', 'v1', 'EntityState', 'Ready');
        $tickets[] = $this->seeder->createTicket('Release', 'v1', 'EntityState', 'In Testing');
        $tickets[] = $this->seeder->createTicket('Release', 'v2', 'EntityState', 'Ready');
        $tickets[] = $this->seeder->createTicket('Release', 'v2', 'EntityState', 'In Testing');
        $tickets[] = $this->seeder->createTicket('Release', 'v2', 'EntityState', 'Ready');
        $tickets[] = $this->seeder->createTicket('Release', 'v2', 'EntityState', 'In Testing');
        return $tickets;
    }

}