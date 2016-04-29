<?php


namespace tests\BLL\TPTable;


use TargetPHProcess\BLL\TPTable\TPTable;
use TargetPHProcess\Models\Ticket;

class TPTableTest extends \PHPUnit_Framework_TestCase
{
    /** @var TPTable */
    private $table;

    public function setUp()
    {
        /** @var Ticket[] $tickets */
        $tickets = [];
        $this->table = new TPTable('EntityState', 'Release', $tickets);
    }

    /** @test */
    public function asf()
    {
        $this->assertTrue(true);
//        /** @var Ticket[] $tickets */
//        $tickets = [];
//        $this->table = new TPTable('EntityState', 'Release', $tickets);
    }


    private function getTickets()
    {
        for ($i = 0; $i < 10; $i++) {
          
        }
    }


}