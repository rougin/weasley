<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Scripts\CreateHandler;

/**
 * @deprecated since ~0.7, use "Scripts/CreateHandler" instead.
 *
 * Make Middleware Command
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MakeMiddlewareCommand extends CreateHandler
{
    /**
     * @var string
     */
    protected $command = 'make:middleware';

    /**
     * @var boolean
     */
    protected $deprecated = true;

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
    protected $text = 'Creates a new v0.4.1 of PSR-15 middleware class';
}
