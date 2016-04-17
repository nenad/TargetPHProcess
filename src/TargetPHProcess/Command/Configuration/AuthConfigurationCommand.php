<?php


namespace TargetPHProcess\Command\Configuration;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TargetPHProcess\BLL\Auth\AuthGenerator;

class AuthConfigurationCommand extends Command
{
    /** @var AuthGenerator */
    private $authGenerator;

    public function __construct(AuthGenerator $authGenerator)
    {
        parent::__construct('config:auth');
        $this->authGenerator = $authGenerator;
    }

    public function configure()
    {
        $this->setDescription('Changes the authentication for the current project');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        echo getcwd();
    }
}