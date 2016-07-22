<?php

namespace {{ application.name }}\{{ namespaces.components }};

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

use Rougin\Slytherin\Component\AbstractComponent;

/**
 * HTTP Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class HttpComponent extends AbstractComponent
{
    /**
     * Type of the component:
     * dispatcher, debugger, http, middleware
     * 
     * @var string
     */
    protected $type = 'http';

    /**
     * Returns an instance from the named class.
     * 
     * @return mixed
     */
    public function get()
    {
        return [ ServerRequestFactory::fromGlobals(), new Response ];
    }
}
