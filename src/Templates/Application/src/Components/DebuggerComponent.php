<?php

namespace {{ application.name }}\{{ namespaces.components }};

use Whoops\Run;

use Rougin\Slytherin\Debug\Whoops\Debugger;
use Rougin\Slytherin\Component\AbstractComponent;

/**
 * Debugger Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class DebuggerComponent extends AbstractComponent
{
    /**
     * Type of the component:
     * dispatcher, debugger, http, middleware
     * 
     * @var string
     */
    protected $type = 'debugger';

    /**
     * Returns an instance from the named class.
     * 
     * @return mixed
     */
    public function get()
    {
        $debugger = new Debugger(new Run);

        $debugger->setEnvironment(config('app.environment'));

        return $debugger;
    }
}
