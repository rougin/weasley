<?php

namespace Rougin\Weasley\Generator\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Make Controller Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MakeControllerCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $filename = 'Controller.stub';

    /**
     * @var string
     */
    protected $message = 'Controller created successfully!';

    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:controller')->setDescription('Create a new HTTP controller class');
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the class');
        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Path for the file to be created', 'src/Http/Controllers');
        $this->addOption('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the class', 'App\Http\Controllers');
        $this->addOption('package', null, InputOption::VALUE_OPTIONAL, 'Name of the package', 'App');
        $this->addOption('author', null, InputOption::VALUE_OPTIONAL, 'Name of the author', 'Rougin Royce Gutib <rougingutib@gmail.com>');
    }
}
