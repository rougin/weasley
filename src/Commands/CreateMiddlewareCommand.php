<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Common\CreateCommand;

/**
 * Create Middleware Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateMiddlewareCommand extends CreateCommand
{
    /**
     * @var string
     */
    protected $type = 'middleware';
}
