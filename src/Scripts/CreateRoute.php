<?php

namespace Rougin\Weasley\Scripts;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CreateRoute extends AbstractMake
{
    /**
     * @var string
     */
    protected $command = 'make:route';

    /**
     * @var string[]
     */
    protected $aliases = array('make:controller');

    /**
     * @var string
     */
    protected $filename = 'Route.stub';

    /**
     * @var string
     */
    protected $message = 'Route created successfully!';

    /**
     * @var string
     */
    protected $namespace = 'App\Routes';

    /**
     * @var string
     */
    protected $path = 'src/Routes';

    /**
     * @var string
     */
    protected $text = 'Creates a new HTTP route class';
}
