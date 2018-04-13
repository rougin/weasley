<?php

namespace Rougin\Weasley\Commands;

/**
 * Make Middleware Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MakeMiddlewareCommand extends MakeControllerCommand
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
    protected $text = 'Create a new v0.4.1 of PSR-15 middleware class';
}
