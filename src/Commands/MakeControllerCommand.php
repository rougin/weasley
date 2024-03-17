<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Make Controller Command
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class MakeControllerCommand extends Command
{
    /**
     * @var string
     */
    protected $command = 'make:controller';

    /**
     * @var string
     */
    protected $filename = 'Controller.stub';

    /**
     * @var string
     */
    protected $message = 'Controller created successfully!';

    /**
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * @var string
     */
    protected $path = 'src/Http/Controllers';

    /**
     * @var string
     */
    protected $text = 'Create a new HTTP controller class';

    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName($this->command)->setDescription($this->text);

        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the class');

        $optional = InputOption::VALUE_OPTIONAL;

        $this->addOption('path', null, $optional, 'Path for the file to be created', $this->path);

        $this->addOption('namespace', null, $optional, 'Namespace of the class', $this->namespace);

        $this->addOption('package', null, $optional, 'Name of the package', 'App');

        $author = 'Rougin Gutib <rougingutib@gmail.com>';

        $this->addOption('author', null, $optional, 'Name of the author', $author);
    }

    /**
     * Executes the current command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = getcwd() . '/' . $input->getOption('path');

        file_exists($path) || mkdir($path, 0777, true);

        $file = $path . '/' . $input->getArgument('name') . '.php';

        file_put_contents($file, $this->stub($input));

        $output->writeln('<info>' . $this->message . '</info>');

        return 0;
    }

    /**
     * Generates a new stub based on the input.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @return string
     */
    protected function stub(InputInterface $input)
    {
        $stub = file_get_contents(__DIR__ . '/../Templates/' . $this->filename);

        $stub = str_replace('$CLASS', $input->getArgument('name'), $stub);

        $stub = str_replace('$NAMESPACE', $input->getOption('namespace'), $stub);

        $stub = str_replace('$PACKAGE', $input->getOption('package'), $stub);

        return str_replace('$AUTHOR', $input->getOption('author'), $stub);
    }
}
