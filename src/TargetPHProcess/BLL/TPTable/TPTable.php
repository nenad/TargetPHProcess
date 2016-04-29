<?php


namespace TargetPHProcess\BLL\TPTable;


use TargetPHProcess\Models\Ticket;

class TPTable
{
    /** @var string */
    private $xAxis;
    /** @var string */
    private $yAxis;
    /** @var array */
    private $tickets;

    public function __construct($xAxis, $yAxis, array $tickets)
    {
        $this->xAxis = $xAxis;
        $this->yAxis = $yAxis;
        $this->tickets = $tickets;
    }
}