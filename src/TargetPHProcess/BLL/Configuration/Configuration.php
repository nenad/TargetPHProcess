<?php


namespace TargetPHProcess\BLL\Configuration;

use TargetPHProcess\SystemConfiguration\ConfigurationWriter;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

class Configuration
{
    /** @var ConfigurationWriter */
    private $writer;

    public function __construct(ConfigurationWriter $writer)
    {
        $this->writer = $writer;
    }

    public function getProjectConfiguration()
    {
        $currentDir = $_SERVER['PWD'];
        $allConfigs = $this->getAllProjectConfigurations();
        /** @var ProjectConfiguration $config */
        foreach ($allConfigs as $config) {
            if (substr_startswith($config->directory, $currentDir)) {
                return $config;
            }
        }
        return null;
    }

    public function getAllProjectConfigurations()
    {
        return json_decode($this->writer->readConfig());
    }

    public function addConfig(ProjectConfiguration $config)
    {

    }
}