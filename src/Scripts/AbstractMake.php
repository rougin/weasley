<?php

namespace Rougin\Weasley\Scripts;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Abstract Make Command
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class AbstractMake extends Command
{
    /**
     * @var string
     */
    protected $command = '';

    /**
     * @var boolean
     */
    protected $deprecated = false;

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
        $this->setName($this->command);

        $text = $this->text;

        if ($this->deprecated)
        {
            $text = '(Deprecated) ' . $text;
        }

        $this->setDescription($text);

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
        $path = __DIR__ . '/Templates/';

        /** @var string */
        $stub = file_get_contents($path . $this->filename);

        /** @var string */
        $name = $input->getArgument('name');
        $stub = str_replace('$CLASS', $name, $stub);

        /** @var string */
        $namespace = $input->getOption('namespace');
        $stub = str_replace('$NAMESPACE', $namespace, $stub);

        /** @var string */
        $package = $input->getOption('package');
        $stub = str_replace('$PACKAGE', $package, $stub);

        /** @var string */
        $author = $input->getOption('author');
        return str_replace('$AUTHOR', $author, $stub);
    }
}
