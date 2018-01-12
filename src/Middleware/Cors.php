<?php

namespace Rougin\Weasley\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * CORS Middleware
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Cors implements MiddlewareInterface
{
    const ALLOW_ORIGIN = 'Access-Control-Allow-Origin';

    const ALLOW_METHODS = 'Access-Control-Allow-Methods';

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

        $this->methods($methods === null ? $methods : $methods);
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
        $response = new \Rougin\Slytherin\Http\Response;

        $options = (boolean) $request->getMethod() === 'OPTIONS';

        $options && $response = $delegate->process($request);

        $response = $response->withHeader(self::ALLOW_ORIGIN, $this->allowed);

        return $response->withHeader(self::ALLOW_METHODS, $this->methods);
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
