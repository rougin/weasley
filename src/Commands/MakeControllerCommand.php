<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeControllerCommand extends \Symfony\Component\Console\Command\Command
{
    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('make:controller')
            ->setDescription('Creates a new HTTP controller.')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the class.')
            ->addArgument('namespace', InputArgument::OPTIONAL, 'Namespace of the class.', 'Skeleton\Http\Controllers')
            ->addArgument('package', InputArgument::OPTIONAL, 'Namespace of the class.', 'Skeleton')
            ->addArgument('author', InputArgument::OPTIONAL, 'Namespace of the class.', 'Rougin Royce Gutib <rougingutib@gmail.com>');
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
        $stub = file_get_contents(__DIR__ . '/../Templates/Controller.stub');

        $output->write('Controller created successfully!');
    }
}
