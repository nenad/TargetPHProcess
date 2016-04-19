<?php


namespace TargetPHProcess\BLL\Configuration;

use TargetPHProcess\SystemConfiguration\ConfigurationWriter;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

class Configuration
{
    private static $instance = null;
    /** @var ConfigurationWriter */
    private $writer;

    private function __construct(ConfigurationWriter $writer)
    {
        $this->writer = $writer;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Configuration(new ConfigurationWriter());
        }
        return self::$instance;
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