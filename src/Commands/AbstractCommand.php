<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Abstract Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var string
     */
    protected $command = '';

    /**
     * @var string
     */
    protected $filename = '';

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $namespace = '';

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $text = '';

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

        $author = 'Rougin Royce Gutib <rougingutib@gmail.com>';

        $this->addOption('author', null, $optional, 'Name of the author', $author);
    }

    /**
     * Executes the current command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Input\OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = getcwd() . '/' . $input->getOption('path');

        file_exists($path) || mkdir($path, 0777, true);

        $file = $path . '/' . $input->getArgument('name') . '.php';

        file_put_contents($file, $this->stub($input));

        $output->writeln('<info>' . $this->message . '</info>');
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