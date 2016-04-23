<?php


namespace TargetPHProcess\Models;


class Time extends Model
{
    /** @var string */
    public $Description;
    /** @var float */
    public $Spent;
    /** @var float */
    public $Remain;
    /** @var bool|null */
    public $IsEstimation;
    /** @var TPDate */
    public $Date;
    /** @var TPDate */
    public $CreateDate;
    /** @var Project */
    public $Project;
    /** @var Assignable */
    public $Assignable;
    /** @var UserStory|null */
    public $UserStory;
    /** @var Bug|null */
    public $Bug;
    /** @var Task|null */
    public $Task;
    /** @var Request|null */
    public $Request;
    /** @var TestPlan|null */
    public $TestPlan;
    /** @var TestPlanRun|null */
    public $TestPlanRun;
    /** @var string|null */
    public $CustomActivity;
    /** @var User */
    public $User;
    /** @var Role|null */
    public $Role;
    /** @var CustomField[] */
    public $CustomFields;
}