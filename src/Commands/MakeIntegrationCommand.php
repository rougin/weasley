<?php

namespace Rougin\Weasley\Commands;

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
     * @var string
     */
    protected $path = 'Integrations';

    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:integration')->setDescription('Creates a new integration.');
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the class.');
        $this->addOption('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the class.', 'Skeleton\Integrations');
        $this->addOption('package', null, InputOption::VALUE_OPTIONAL, 'Name of the package.', 'Skeleton');
        $this->addOption('author', null, InputOption::VALUE_OPTIONAL, 'Name of the author.', 'Rougin Royce Gutib <rougingutib@gmail.com>');
    }
}
