<?php

namespace {{ application.name }}\{{ namespaces.components }};

/**
 * Middleware Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class MiddlewareComponent extends \Rougin\Slytherin\Component\AbstractComponent
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
        $pipe = new \Zend\Stratigility\MiddlewarePipe;

        return new \Rougin\Slytherin\Middleware\Stratigility\Middleware($pipe);
    }
}
