<?php

namespace {{ application.name }}\{{ namespaces.components }};

use Rougin\Slytherin\Dispatching\Vanilla\Router;
use Rougin\Slytherin\Component\AbstractComponent;
use Rougin\Slytherin\Dispatching\Vanilla\Dispatcher;

/**
 * Dispatcher Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class DispatcherComponent extends AbstractComponent
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
        $routes = require __DIR__ . '/../Http/routes.php';

        return new Dispatcher(new Router($routes));
    }
}
