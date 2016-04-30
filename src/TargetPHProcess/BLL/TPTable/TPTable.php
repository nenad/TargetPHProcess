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

    public function getTicketsFromXAxis($xAxis)
    {
        $xTickets = [];
        foreach ($this->tickets as $ticket) {
            if ($ticket->{$this->xAxis} === $xAxis) {
                $xTickets[] = $ticket;
            }
        }
        return $xTickets;
    }

    public function getTicketsFromYAxis($yAxis)
    {
        $yTickets = [];
        foreach ($this->tickets as $ticket) {
            if ($ticket->{$this->yAxis} === $yAxis) {
                $yTickets[] = $ticket;
            }
        }
        return $yTickets;
    }

}