<?php

namespace {{ application.name }}\{{ namespaces.components }};

use Zend\Stratigility\MiddlewarePipe;

use Rougin\Slytherin\Component\AbstractComponent;
use Rougin\Slytherin\Middleware\Stratigility\Middleware;

/**
 * Middleware Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class MiddlewareComponent extends AbstractComponent
{
    /**
     * Type of the component:
     * dispatcher, debugger, http, middleware
     *
     * @var string
     */
    protected $type = 'middleware';

    /**
     * Returns an instance from the named class.
     *
     * @return mixed
     */
    public function get()
    {
        return new Middleware(new MiddlewarePipe);
    }
}
