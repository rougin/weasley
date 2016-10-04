<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Common\CreateCommand;

/**
 * Create Validator Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateValidatorCommand extends CreateCommand
{
    /**
     * @var string
     */
    protected $type = 'validator';

    /**
     * @var string
     */
    protected $description = 'Creates a new Valitron-based validator';
}
