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
class MakeValidatorCommand extends MakeControllerCommand
{
    /**
     * @var string
     */
    protected $command = 'make:validator';

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
    protected $namespace = 'App\Validators';

    /**
     * @var string
     */
    protected $path = 'src/Validators';

    /**
     * @var string
     */
    protected $text = 'Create a new validator class';
}
