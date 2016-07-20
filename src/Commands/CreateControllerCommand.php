<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Common\Commands\CreateCommand;

/**
 * Create Controller Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateControllerCommand extends CreateCommand
{
    /**
     * @var string
     */
    protected $type = 'controller';
}
