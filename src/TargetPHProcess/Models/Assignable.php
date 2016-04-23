<?php


namespace TargetPHProcess\Models;


class Assignable
{
    /** @var string */
    public $ResourceType;
    /** @var string */
    public $Name;
    /** @var string */
    public $Description;
    /** @var TPDate */
    public $StartDate;
    /** @var TPDate */
    public $EndDate;
    /** @var TPDate */
    public $CreateDate;
    /** @var TPDate */
    public $ModifyDate;
    /** @var TPDate */
    public $LastCommentDate;
    /** @var string */
    public $Tags;
    /** @var float */
    public $NumericPriority;
    /** @var int */
    public $Effort;
    /** @var int */
    public $EffortCompleted;
    /** @var int */
    public $EffortToDo;
    /** @var int */
    public $Progress;
    /** @var float */
    public $TimeSpent;
    /** @var float */
    public $TimeRemain;
    /** @var TPDate */
    public $PlannedStartDate;
    /** @var TPDate */
    public $PlannedEndDate;
    /** @var EntityType */
    public $EntityType;
    /** @var Project */
    public $Project;
    /** @var User */
    public $Owner;
    /** @var User */
    public $LastCommentedUser;
    /** @var TestPlan|null */
    public $LinkedTestPlan;
    /** @var Release */
    public $Release;
    /** @var Iteration|null */
    public $Iteration;
    /** @var Iteration|null */
    public $TeamIteration;
    /** @var Team */
    public $Team;
    /** @var Priority */
    public $Priority;
    /** @var EntityState */
    public $EntityState;
    /** @var Team */
    public $ResponsibleTeam;
    /** @var CustomField[] */
    public $CustomFields;
}