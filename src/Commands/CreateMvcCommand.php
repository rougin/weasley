<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Rougin\Weasley\Common\Configuration;
use Rougin\Weasley\Common\Commands\AbstractCommand;

/**
 * Create MVC Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateMvcCommand extends AbstractCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $config = Configuration::get();

        $this
            ->setName('make:mvc')
            ->setDescription('Creates a new controller, model, view, repository and validator')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Base table name for the files'
            )->addOption(
                'overwrite',
                null,
                InputOption::VALUE_NONE,
                'Overwrite the specified files'
            );
    }

    /**
     * Executes the command.
     * 
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return object|\Symfony\Component\Console\Output\OutputInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = [
            'make:controller',
            'make:model',
            'make:view',
            'make:repository',
            'make:validator',
        ];

        foreach ($commands as $command) {
            $arguments = [
                'command'     => $command,
                'name'        => $input->getArgument('name'),
                '--overwrite' => $input->getOption('overwrite'),
            ];

            $input = new ArrayInput($arguments);

            $application = $this->getApplication()->find($command);
            $application->run($input, $output);
        }
    }
}
