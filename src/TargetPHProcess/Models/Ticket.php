<?php


namespace TargetPHProcess\Models;


class Ticket
{
    /** @var Assignable */
    private $Assignable;

    /** @var string */
    public $EntityState;
    /** @var string */
    public $Name;
    /** @var int */
    public $Id;
    /** @var string */
    public $Release;
    /** @var string */
    public $Project;

    public function __construct(Assignable $assignable)
    {
        $this->Assignable = $assignable;
        $this->Release = $assignable->Release->Name;
        $this->Id = $assignable->Id;
        $this->EntityState = $assignable->EntityState->Name;
        $this->Name = $assignable->Name;
        $this->Project = $assignable->Project->Name;
    }

    public function getAssignable()
    {
        return $this->Assignable;
    }
}