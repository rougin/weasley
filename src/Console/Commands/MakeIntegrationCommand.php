<?php

namespace Rougin\Weasley\Console\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Make Integration Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MakeIntegrationCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $filename = 'Integration.stub';

    /**
     * @var string
     */
    protected $message = 'Integration created successfully!';

    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:integration')->setDescription('Create a new integration class');
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the class');

        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Path for the file to be created', 'src/Integrations');
        $this->addOption('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the class', 'App\Integrations');
        $this->addOption('package', null, InputOption::VALUE_OPTIONAL, 'Name of the package', 'App');
        $this->addOption('author', null, InputOption::VALUE_OPTIONAL, 'Name of the author', 'Rougin Royce Gutib <rougingutib@gmail.com>');
    }
}
