<?php


namespace TargetPHProcess\BLL\TargetProcess;


use TargetPHProcess\BLL\Configuration\Configuration;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

abstract class AbstractTargetProcess
{
    /** @var ProjectConfiguration */
    protected $configuration;

    public function __construct()
    {
        $this->configuration = Configuration::getInstance()->getProjectConfiguration();
    }

    public function hasConfiguration()
    {
        return $this->configuration != null;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function setConfiguration(ProjectConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function sendRequest()
    {
        
    }
}