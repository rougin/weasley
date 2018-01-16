<?php

namespace Rougin\Weasley\Commands;

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
    protected $command = 'make:middleware';

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
    protected $namespace = 'App\Http\Middleware';

    /**
     * @var string
     */
    protected $path = 'src/Http/Middleware';

    /**
     * @var string
     */
    protected $text = 'Create a new HTTP middleware class';
}
