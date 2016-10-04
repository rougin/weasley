<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Common\CreateCommand;

/**
 * Create Model Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateModelCommand extends CreateCommand
{
    /**
     * @var string
     */
    protected $type = 'model';
}
