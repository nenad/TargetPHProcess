<?php


namespace TargetPHProcess\BLL\TargetProcess\Projects;


use TargetPHProcess\BLL\TargetProcess\AbstractTargetProcess;

class Project extends AbstractTargetProcess
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProjects()
    {
        $p1 = new \TargetPHProcess\Models\Project();
        $p1->name = 'hello';
        $p2 = new \TargetPHProcess\Models\Project();
        $p2->name = 'world';
        return [$p1, $p2];
    }
}