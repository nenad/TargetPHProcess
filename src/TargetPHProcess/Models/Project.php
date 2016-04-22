<?php


namespace TargetPHProcess\Models;

class Project extends Model
{
    /** @var string */
    public $Name;
    /** @var string */
    public $Description;
    /** @var string */
    public $ResourceType;
    /** @var Process */
    public $Process;
    /** @var User */
    public $Owner;
    /** @var EntityState */
    public $EntityState;
    
    
    public function __toString()
    {
        return $this->Name;
    }
}