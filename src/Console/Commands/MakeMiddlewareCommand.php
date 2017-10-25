<?php

namespace Rougin\Weasley\Console\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Make Middleware Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MakeMiddlewareCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $filename = 'Middleware.stub';

    /**
     * @var string
     */
    protected $message = 'Middleware created successfully!';

    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:middleware')->setDescription('Create a new PSR-15 middleware class');
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the class');
        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Path for the file to be created', 'src/Http/Middleware');
        $this->addOption('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the class', 'App\Http\Middleware');
        $this->addOption('package', null, InputOption::VALUE_OPTIONAL, 'Name of the package', 'App');
        $this->addOption('author', null, InputOption::VALUE_OPTIONAL, 'Name of the author', 'Rougin Royce Gutib <rougingutib@gmail.com>');
    }
}
