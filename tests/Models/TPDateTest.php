<?php


namespace tests\Models;


use Exception;
use TargetPHProcess\Models\TPDate;

class TPDateTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function createDateFromMilliseconds()
    {
        date_default_timezone_set('GMT');
        $tpdate = new TPDate('Date(1460379452000)');
        $this->assertEquals('2016-04-11 12:57:32', $tpdate->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function createDateFromMillisecondsAndOffset()
    {
        date_default_timezone_set('GMT');
        $tpdate = new TPDate('Date(1460379452000+0200)');
        $this->assertEquals('2016-04-11 14:57:32', $tpdate->format('Y-m-d H:i:s'));
    }
    
    /** @test */
    public function createDateFromMillisecondsAndNegativeOffset()
    {
        date_default_timezone_set('GMT');
        $tpdate = new TPDate('Date(1460379452000-0200)');
        $this->assertEquals('2016-04-11 10:57:32', $tpdate->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     * @expectedException Exception
     */

    public function failCreation()
    {
        $tpdate = new TPDate('Dat460379452000+0200');
    }
}

