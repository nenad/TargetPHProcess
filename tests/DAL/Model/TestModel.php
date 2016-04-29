<?php


namespace Tests\DAL\Model;


use TargetPHProcess\Models\Model;
use TargetPHProcess\Models\Time;

class TestModel extends Model
{
    /** @var string */
    public $Name;
    
    /** @var string */
    public $Description;
    
    /** @var Time[] */
    public $Times;
}