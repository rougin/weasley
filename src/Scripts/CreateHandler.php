<?php

namespace Rougin\Weasley\Scripts;

/**
 * Create Handler Command
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CreateHandler extends AbstractMake
{
    /**
     * @var string
     */
    protected $command = 'make:handler';

    /**
     * @var string[]
     */
    protected $aliases = array('make:middleware');

    /**
     * @var string
     */
    protected $filename = 'Handler.stub';

    /**
     * @var string
     */
    protected $message = 'Handler created successfully!';

    /**
     * @var string
     */
    protected $namespace = 'App\Handlers';

    /**
     * @var string
     */
    protected $path = 'src/Handlers';

    /**
     * @var string
     */
    protected $text = 'Create a new Slytherin Middleware class';
}
