<?php


namespace TargetPHProcess\Command\Configuration;


use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use TargetPHProcess\BLL\Auth\AuthGenerator;
use TargetPHProcess\BLL\Configuration\Configuration;
use TargetPHProcess\DAL\Model\ProjectRepository;
use TargetPHProcess\Models\Project;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

class InitCommand extends Command
{
    /** @var AuthGenerator */
    private $authGenerator;
    /** @var Project */
    private $project;
    /* @var Configuration */
    private $configuration;

    public function __construct(Configuration $configuration, AuthGenerator $authGenerator, ProjectRepository $project)
    {
        parent::__construct('init');
        $this->authGenerator = $authGenerator;
        $this->project = $project;
        $this->configuration = $configuration;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->setDecorated(true);
        /** @var QuestionHelper $question */
        $question = $this->getHelper('question');

        $output->writeln('------------------------------------');
        $output->writeln('--- <info>TargetProcess authentication</info> ---');
        $output->writeln('------------------------------------');

        $tpUrlQuestion = new Question('TargetProcess URL <comment>(ex. http://tp.mysite.com)</comment>: ');
        $tpUsernameQuestion = new Question('Username: ');
        $tpPasswordQuestion = new Question('Password: ');
        $tpPasswordQuestion->setHidden(true);

        while (true) {
            try {
                $output->writeln('');
                $tpUrl = $question->ask($input, $output, $tpUrlQuestion);
                $tpUsername = $question->ask($input, $output, $tpUsernameQuestion);
                $tpPassword = $question->ask($input, $output, $tpPasswordQuestion);

                $output->writeln('');
                $output->writeln('--- <info>Fetching projects...</info> ---');
                $output->writeln('');

                $projectConfig = new ProjectConfiguration();
                $projectConfig->auth = $this->authGenerator->generateBasicAuth($tpUsername, $tpPassword);
                $projectConfig->directory = $_SERVER['PWD'];
                $projectConfig->tp_url = $tpUrl;

                $this->project->setConfiguration($projectConfig);
                $projects = $this->project->getAllProjectNames();
                $tpProjectsQuestion = new ChoiceQuestion('Current project: ', $projects);

                $tpProjectAnswer = $question->ask($input, $output, $tpProjectsQuestion);
                $projectId = $this->extractID($tpProjectAnswer);
                $projectConfig->project_id = $projectId;
                $this->project->setConfiguration($projectConfig);

                $this->configuration->addConfig($projectConfig);
                $this->configuration->saveConfig();
                $output->write('');
                $output->write('<info>Configuration saved!</info>');
                break;
            } catch (Exception $ex) {
                $output->writeln('');
                $output->writeln("<error>Input invalid. Try again ({$ex->getMessage()})</error>");
                $output->writeln('');
            }
        }
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Initializes a TP project in the current directory');
    }

    private function extractID($projectInput)
    {
        preg_match("/.*\((\d+)\)/", $projectInput, $outputArray);
        return (int)$outputArray[1];
    }
}