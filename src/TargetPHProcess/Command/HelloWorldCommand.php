<?php


namespace TargetPHProcess\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TargetPHProcess\BLL\Auth\AuthGenerator;

class HelloWorldCommand extends Command
{
    /** @var AuthGenerator */
    private $authGenerator;

    public function __construct(AuthGenerator $authGenerator)
    {
        parent::__construct('hello');
        $this->authGenerator = $authGenerator;
    }

    protected function configure()
    {
        parent::configure();
        $this->setDescription("Says hello");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write("Hello world!");
        $output->write($this->authGenerator->generateHeader('nenad', 'stojanovikj'));
    }
}