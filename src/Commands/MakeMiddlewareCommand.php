<?php

namespace Rougin\Weasley\Commands;

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
     * @var string
     */
    protected $path = 'Http/Middleware';

    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:middleware')->setDescription('Creates a new PSR-15 middleware.');
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the class.');
        $this->addOption('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the class.', 'Skeleton\Http\Middleware');
        $this->addOption('package', null, InputOption::VALUE_OPTIONAL, 'Name of the package.', 'Skeleton');
        $this->addOption('author', null, InputOption::VALUE_OPTIONAL, 'Name of the author.', 'Rougin Royce Gutib <rougingutib@gmail.com>');
    }
}
