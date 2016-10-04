<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Common\CreateCommand;

/**
 * Create Repository Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateRepositoryCommand extends CreateCommand
{
    /**
     * @var string
     */
    protected $type = 'repository';

    /**
     * @var string
     */
    protected $description = 'Creates a new Doctrine-based repository';
}
