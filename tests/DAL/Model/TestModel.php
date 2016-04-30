<?php


namespace Tests\DAL\Model;


use TargetPHProcess\Models\Model;
use TargetPHProcess\Models\Time;

class TestModel extends Model
{
    /** @var string|null */
    public $Name;
    
    /** @var string|null */
    public $Description;
    
    /** @var TestModelArray[]|null */
    public $TestModelArrays;
}