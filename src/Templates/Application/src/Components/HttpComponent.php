<?php

namespace {{ application.name }}\{{ namespaces.components }};

/**
 * HTTP Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class HttpComponent extends \Rougin\Slytherin\Component\AbstractComponent
{
    /**
     * Type of the component:
     * dispatcher, debugger, http, middleware
     *
     * @var string
     */
    protected $type = 'http';

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Returns an instance from the named class.
     *
     * @return mixed
     */
    public function get()
    {
        $request  = \Zend\Diactoros\ServerRequestFactory::fromGlobals();
        $response = new \Zend\Diactoros\Response;

        // Guess the protocol and the root URI
        if ($request->getUri() && ! config('app.base_url')) {
            $request = \Rougin\Slytherin\Http\BaseUriGuesser::guess($request);
        }

        $this->request  = $request;
        $this->response = $response;

        return [ $this->request, $this->response ];
    }

    /**
     * Sets the component.
     *
     * @param  \Interop\Container\ContainerInterface $container
     * @return void
     */
    public function set(\Interop\Container\ContainerInterface &$container)
    {
        if ($container instanceof \Rougin\Slytherin\IoC\Vanilla\Container) {
            $container->add('Psr\Http\Message\ServerRequestInterface', $this->request);
            $container->add('Psr\Http\Message\ResponseInterface', $this->response);
        }
    }
}
