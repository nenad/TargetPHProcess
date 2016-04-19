<?php


namespace TargetPHProcess\Command\Configuration;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use TargetPHProcess\BLL\Auth\AuthGenerator;
use TargetPHProcess\BLL\TargetProcess\Projects\Project;
use TargetPHProcess\SystemConfiguration\ConfigurationWriter;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

class InitCommand extends Command
{
    /** @var ConfigurationWriter */
    private $configWriter;
    /** @var AuthGenerator */
    private $authGenerator;
    /** @var Project */
    private $project;

    public function __construct(ConfigurationWriter $writer, AuthGenerator $authGenerator, Project $project)
    {
        parent::__construct('init');
        $this->configWriter = $writer;
        $this->authGenerator = $authGenerator;
        $this->project = $project;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $question */
        $question = $this->getHelper('question');
        
        $output->writeln('------------------------------------');
        $output->writeln('--- TargetProcess authentication ---');
        $output->writeln('------------------------------------');
        $output->writeln('');

        $tpUrlQuestion = new Question('TargetProcess URL (ex. http://tp.mysite.com): ');
        $tpUsernameQuestion = new Question('Username: ');
        $tpPasswordQuestion = new Question('Password: ');
        $tpPasswordQuestion->setHidden(true);

        $tpUrl = $question->ask($input, $output, $tpUrlQuestion);
        $tpUsername = $question->ask($input, $output, $tpUsernameQuestion);
        $tpPassword = $question->ask($input, $output, $tpPasswordQuestion);

        $output->writeln('');
        $output->writeln('--- Fetching projects... ---');
        $output->writeln('');

        $projectConfig = new ProjectConfiguration();
        $projectConfig->auth = $this->authGenerator->generateHeader($tpUsername, $tpPassword);
        $projectConfig->directory = $_SERVER['PWD'];
        $projectConfig->tp_url = $tpUrl;
        
        $this->project->setConfiguration($projectConfig);
        $projects = $this->project->getAllProjects();

        $tpProjectsQuestion = new ChoiceQuestion('Current project: ', $projects);
        $tpProject = $question->ask($input, $output, $tpProjectsQuestion);

        echo "{$tpUrl} {$tpUsername} {$tpPassword} {$tpProject}";
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Initializes a TP project in the current directory');
    }
}