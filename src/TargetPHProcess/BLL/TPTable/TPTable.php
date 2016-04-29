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
    /** @var array */
    private $tableTickets = [];

    public function __construct($xAxis, $yAxis, array $tickets)
    {
        $this->xAxis = $xAxis;
        $this->yAxis = $yAxis;
        $this->tickets = $tickets;
        $this->orderTicketsByAxis();
    }

    private function orderTicketsByAxis()
    {
        /** @var Ticket $ticket */
        foreach ($this->tickets as $ticket) {
            $ticketX = $ticket->{$this->xAxis};
            $ticketY = $ticket->{$this->yAxis};
            $this->tableTickets[$ticketX][$ticketY][] = $ticket;
        }
    }

    public function getTicketCount()
    {
        return count($this->tickets);
    }

    public function getTicketsFromAxis($xAxis, $yAxis)
    {
        try {
            return $this->tableTickets[$xAxis][$yAxis];
        } catch (\Exception $ex) {
            return [];
        }
    }

    public function getTicketsFromYAxis($yAxis)
    {

    }

    public function getTicketsFromXAxis($xAxis)
    {

    }
}