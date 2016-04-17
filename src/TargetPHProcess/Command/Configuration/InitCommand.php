<?php


namespace TargetPHProcess\Command\Configuration;


use Symfony\Component\Console\Command\Command;

class InitCommand extends Command
{
    public function __construct()
    {
        parent::__construct('config:init');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Initializes a TP project in the current directory');
    }
}