<?php

namespace TargetPHProcess\DAL\Model;

class Project extends AbstractTargetProcessModel
{
    public function getAllProjects()
    {
        $p1 = new \TargetPHProcess\Models\Project();
        $p1->name = 'hello';
        $p2 = new \TargetPHProcess\Models\Project();
        $p2->name = 'world';
        return [$p1, $p2];
    }
}