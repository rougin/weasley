<?php

namespace Rougin\Weasley\Commands;

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
    protected $command = 'make:controller';

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
    protected $namespace = 'App\Http\Controllers';

    /**
     * @var string
     */
    protected $path = 'src/Http/Controllers';

    /**
     * @var string
     */
    protected $text = 'Create a new HTTP controller class';
}
