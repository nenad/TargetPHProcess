<?php

namespace TargetPHProcess\DAL\Model;

use TargetPHProcess\Models\Project;

class ProjectRepository extends TPModel
{
    protected $model = Project::class;
    protected $modelEntity = 'Projects';

    public function getAllProjects()
    {
        return $this->includeAll()->get();
    }

    public function getAllProjectNames()
    {
        $projects = $this->getAllProjects();
        $names = array_map(function (Project $project) {
            return "$project->Name ($project->Id)";
        }, $projects);
        return $names;
    }
}