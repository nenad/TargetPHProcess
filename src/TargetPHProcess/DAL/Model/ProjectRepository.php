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

    /**
     * @param $id
     * @return Project
     */
    public function find($id)
    {
        return $this->setId($id)->includeAll()->get();
    }
}