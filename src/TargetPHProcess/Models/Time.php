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
    /** @var bool */
    public $IsEstimation;
    /** @var TPDate */
    public $Date;
    /** @var TPDate */
    public $CreateDate;
    /** @var Project */
    public $Project;
    /** @var Assignable */
    public $Assignable;
    /** @var UserStory */
    public $UserStory;
    /** @var Bug */
    public $Bug;
    /** @var Task */
    public $Task;
    /** @var Request */
    public $Request;
    /** @var TestPlan */
    public $TestPlan;
    /** @var TestPlanRun */
    public $TestPlanRun;
    /** @var string */
    public $CustomActivity;
    /** @var User */
    public $User;
    /** @var Role */
    public $Role;
    /** @var CustomField[] */
    public $CustomFields;
}