<?php


namespace TargetPHProcess\BLL\Console;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class TPDefinition extends InputDefinition
{
    public function __construct()
    {
        parent::__construct([]);
        $this->addArgument(new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'));
        $this->addOption(new InputOption('--version', '-V', InputOption::VALUE_NONE,
            'Display this application version'));
    }
}