<?php


namespace TargetPHProcess\SystemConfiguration;


class ConfigurationWriter
{
    private $homeDirectory;
    public $configPath;

    public function __construct()
    {
        $this->homeDirectory = $_SERVER['HOME'];
        $this->configPath = $this->homeDirectory . '/.tpconfig';

        if (!is_file($this->configPath)) {
            touch($this->configPath);
            file_put_contents($this->configPath, '[]');
        }
    }
    
    public function writeConfig($json)
    {
        file_put_contents($this->configPath, $json, FILE_TEXT);
    }

    public function readConfig()
    {
        return file_get_contents($this->configPath);
    }
}