<?php

namespace TargetPHProcess\DAL\Model;

use TargetPHProcess\Models\Project;

class ProjectRepository extends AbstractTargetProcessModel
{
    protected $model = 'Projects';

    public function getAllProjects()
    {
        $p1 = new Project();
        $p1->Name = 'hello';
        $p2 = new Project();
        $p2->Name = 'world';
        return [$p1, $p2];
    }

    public function find($id)
    {

    }
}