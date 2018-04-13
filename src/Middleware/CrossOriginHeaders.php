<?php

namespace Rougin\Weasley\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Cross Origin Headers Middleware
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CrossOriginHeaders implements MiddlewareInterface
{
    /**
     * @var array
     */
    protected $allowed = array();

    /**
     * @var array
     */
    protected $methods = array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS');

    /**
     * Initializes the middleware instance.
     *
     * @param array|null $allowed
     * @param array|null $methods
     */
    public function __construct(array $allowed = null, array $methods = null)
    {
        $defaults = array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS');

        $this->allowed($allowed === null ? array('*') : $allowed);

        $this->methods($methods === null ? $methods : $defaults);
    }

    /**
     * Process an incoming server request and return a response, optionally
     * delegating to the next middleware component to create the response.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface         $request
     * @param  \Interop\Http\ServerMiddleware\DelegateInterface $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $origin = 'Access-Control-Allow-Origin';

        $method = 'Access-Control-Allow-Methods';

        if ($request->getMethod() !== 'OPTIONS') {
            $response = $delegate->process($request);

            $result = $response->withHeader($origin, $this->allowed);

            $response = $result->withHeader($method, $this->methods);

            return $response;
        }

        return new \Rougin\Slytherin\Http\Response;
    }

    /**
     * Sets the allowed URLS.
     *
     * @param  array $allowed
     * @return self
     */
    public function allowed($allowed)
    {
        $this->allowed = $allowed;

        return $this;
    }

    /**
     * Sets the allowed HTTP methods.
     *
     * @param  array $methods
     * @return self
     */
    public function methods($methods)
    {
        $this->methods = $methods;

        return $this;
    }
}