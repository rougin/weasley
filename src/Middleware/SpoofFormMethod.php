<?php

namespace Rougin\Weasley\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Slytherin\Middleware\HandlerInterface;
use Rougin\Slytherin\Middleware\MiddlewareInterface;

/**
 * Spoof Form Method Middleware
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class SpoofFormMethod implements MiddlewareInterface
{
    /**
     * @var string
     */
    protected $key = '';

    /**
     * Initializes the middleware instance.
     *
     * @param string|null $key
     */
    public function __construct($key = null)
    {
        $this->key($key === null ? '_method' : $key);
    }

    /**
     * Process an incoming server request and return a response, optionally
     * delegating to the next middleware component to create the response.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface      $request
     * @param  \Rougin\Slytherin\Middleware\HandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        $parsed = $request->getParsedBody();

        if (isset($parsed[$this->key]) === true)
        {
            $method = strtoupper($parsed[$this->key]);

            $request = $request->withMethod($method);
        }

        return $handler->handle($request);
    }

    /**
     * Sets the key for the HTTP method.
     *
     * @param  string $key
     * @return self
     */
    public function key($key)
    {
        $this->key = $key;

        return $this;
    }
}
