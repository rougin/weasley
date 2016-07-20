<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Common\Commands\CreateCommand;

/**
 * Create Component Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateComponentCommand extends CreateCommand
{
    /**
     * @var string
     */
    protected $type = 'component';
}
