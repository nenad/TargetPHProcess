<?php


namespace TargetPHProcess\BLL\Configuration;

use JsonMapper;
use TargetPHProcess\SystemConfiguration\ConfigurationWriter;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

class Configuration
{
    static $isLoaded = false;

    /** @var ConfigurationWriter */
    private $writer;

    /** @var ProjectConfiguration[] */
    private $configs = [];

    public function __construct(ConfigurationWriter $writer, JsonMapper $mapper)
    {
        $this->writer = $writer;
        $this->mapper = $mapper;

        if (!self::$isLoaded) {
            self::$isLoaded = true;
            $this->loadConfig();
        }
    }

    public function getProjectConfiguration()
    {
        $currentDir = $_SERVER['PWD'];
        /** @var ProjectConfiguration $config */
        foreach ($this->configs as $config) {
            if (substr_startswith($config->directory, $currentDir)) {
                return $config;
            }
        }
        return null;
    }

    public function getAllProjectConfigurations()
    {
        return $this->configs;
    }

    public function addConfig(ProjectConfiguration $configuration)
    {
        $oldIndex = count($this->configs);
        foreach ($this->configs as $index => $config) {
            if ($config->directory == $configuration->directory) {
                $oldIndex = $index;
                break;
            }
        }
        $this->configs[$oldIndex] = $configuration;
    }

    public function saveConfig()
    {
        $this->writer->writeConfig(json_encode($this->configs));
    }

    public function loadConfig()
    {
        $configs = json_decode($this->writer->readConfig());
        if (count($configs) > 0) {
            $this->configs = $this->mapper->mapArray($configs, $this->configs, ProjectConfiguration::class);
        }
    }
}