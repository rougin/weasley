<?php

namespace {{ application.name }}\{{ namespaces.components }};

/**
 * Debugger Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class DebuggerComponent extends \Rougin\Slytherin\Component\AbstractComponent
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
        $whoops   = new \Whoops\Run;
        $debugger = new \Rougin\Slytherin\Debug\Whoops\Debugger($whoops);

        $debugger->setEnvironment(config('app.environment'));

        return $debugger;
    }
}
