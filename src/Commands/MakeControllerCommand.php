<?php

namespace Rougin\Weasley\Commands;

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
     * @var string
     */
    protected $path = 'Http/Controllers';

    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:controller')->setDescription('Creates a new HTTP controller.');
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the class.');
        $this->addOption('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the class.', 'Skeleton\Http\Controllers');
        $this->addOption('package', null, InputOption::VALUE_OPTIONAL, 'Name of the package.', 'Skeleton');
        $this->addOption('author', null, InputOption::VALUE_OPTIONAL, 'Name of the author.', 'Rougin Royce Gutib <rougingutib@gmail.com>');
    }
}
