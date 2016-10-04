<?php

namespace {{ application.name }}\{{ namespaces.components }};

/**
 * Dispatcher Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class DispatcherComponent extends \Rougin\Slytherin\Component\AbstractComponent
{
    /**
     * Type of the component:
     * dispatcher, debugger, http, middleware
     *
     * @var string
     */
    protected $type = 'dispatcher';

    /**
     * Returns an instance from the named class.
     *
     * @return mixed
     */
    public function get()
    {
        $routes = require base('{{ files.routes }}');
        $router = new \Rougin\Slytherin\Dispatching\Vanilla\Router($routes);

        return new \Rougin\Slytherin\Dispatching\Vanilla\Dispatcher($router);
    }
}
