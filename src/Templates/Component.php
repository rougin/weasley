<?php

namespace {{ application.name }}\{{ namespaces.components }};

use Rougin\Slytherin\Component\AbstractComponent;

/**
 * {{ name | title }} Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class {{ name | title }}Component extends AbstractComponent
{
    /**
     * Types of components:
     * "dispatcher", "debugger", "http", "middleware".
     * 
     * @var string
     */
    protected $type = '';

    /**
     * Returns an instance from the named class.
     * 
     * @return mixed
     */
    public function get()
    {
        //
    }
}
