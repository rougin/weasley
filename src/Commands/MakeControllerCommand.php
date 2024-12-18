<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Scripts\CreateRoute;

/**
 * @deprecated since ~0.7, use "Scripts/CreateRoute" instead.
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MakeControllerCommand extends CreateRoute
{
    /**
     * @var string
     */
    protected $command = 'make:controller';

    /**
     * @var boolean
     */
    protected $deprecated = true;

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
    protected $text = 'Creates a new HTTP controller class';
}
