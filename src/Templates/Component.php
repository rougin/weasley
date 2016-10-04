<?php

namespace {{ application.name }}\{{ namespaces.components }};

/**
 * {{ name | title | replace({ '_': ' ' }) }} Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class {{ nameTitle }}Component extends \Rougin\Slytherin\Component\AbstractComponent
{
    /**
     * Types of components:
     * "dispatcher", "debugger", "http", "middleware".
     * 
     * @var string
     */
    protected $type = '';

    /**
     * Sets the component.
     *
     * @param  \Interop\Container\ContainerInterface $container
     * @return void
     */
    public function set(\Interop\Container\ContainerInterface &$container)
    {
        //
    }
}
