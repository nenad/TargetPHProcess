<?php

namespace TargetPHProcess\DAL\Model;

use TargetPHProcess\Models\Project;

class ProjectRepository extends AbstractTargetProcessModel
{
    protected $model = Project::class;
    protected $modelEntity = 'Projects';

    public function getAllProjects()
    {
        return $this->includeAll()->get();
    }
}