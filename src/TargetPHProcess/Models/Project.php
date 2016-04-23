<?php


namespace TargetPHProcess\Models;

class Project extends Model
{
    /** @var string */
    public $Name;
    /** @var string|null */
    public $Description;
    /** @var string */
    public $ResourceType;
    /** @var Process */
    public $Process;
    /** @var User */
    public $Owner;
    /** @var EntityState */
    public $EntityState;
}