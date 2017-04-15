<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Make Validator Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MakeValidatorCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $filename = 'Validator.stub';

    /**
     * @var string
     */
    protected $message = 'Validator created successfully!';

    /**
     * @var string
     */
    protected $path = 'Validators';

    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:validator')->setDescription('Creates a new validator.');
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the class.');
        $this->addOption('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the class.', 'Skeleton\Validators');
        $this->addOption('package', null, InputOption::VALUE_OPTIONAL, 'Name of the package.', 'Skeleton');
        $this->addOption('author', null, InputOption::VALUE_OPTIONAL, 'Name of the author.', 'Rougin Royce Gutib <rougingutib@gmail.com>');
    }
}
