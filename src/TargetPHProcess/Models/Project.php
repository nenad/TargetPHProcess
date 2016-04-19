<?php


namespace TargetPHProcess\Models;


/**
 * @property string name
 */
class Project extends Model
{
    public function __toString()
    {
        return $this->name;
    }
}