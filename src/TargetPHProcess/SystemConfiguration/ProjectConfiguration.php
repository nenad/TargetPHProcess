<?php


namespace TargetPHProcess\SystemConfiguration;


class ProjectConfiguration implements \Serializable
{
    public $directory;
    public $project_id;
    public $auth;
    public $tp_url;

    public function serialize()
    {
        return serialize([
            'directory' => $this->directory,
            'project_id' => $this->project_id,
            'auth' => $this->auth,
            'tp_url' => $this->tp_url
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->directory = $data['directory'];
        $this->project_id = $data['project_id'];
        $this->tp_url = $data['tp_url'];
        $this->auth = $data['auth'];
    }
}