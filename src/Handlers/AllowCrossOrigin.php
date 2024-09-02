<?php

namespace Rougin\Weasley\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Slytherin\Middleware\HandlerInterface;
use Rougin\Slytherin\Middleware\MiddlewareInterface;
use Rougin\Slytherin\Http\Response;

/**
 * Allow Cross Origin Headers Middleware
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class AllowCrossOrigin implements MiddlewareInterface
{
    const METHODS = 'Access-Control-Allow-Methods';

    const ORIGIN = 'Access-Control-Allow-Origin';

    /**
     * @var string[]
     */
    protected $allowed = array();

    /**
     * @var string[]
     */
    protected $methods = array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS');

    /**
     * Initializes the middleware instance.
     *
     * @param string[]|null $allowed
     * @param string[]|null $methods
     */
    public function __construct(array $allowed = null, array $methods = null)
    {
        $this->allowed($allowed === null ? array('*') : $allowed);

        $this->methods($methods === null ? $this->methods : $methods);
    }

    /**
     * Process an incoming server request and return a response, optionally
     * delegating to the next middleware component to create the response.
     *
     * @param \Psr\Http\Message\ServerRequestInterface      $request
     * @param \Rougin\Slytherin\Middleware\HandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        $options = $request->getMethod() === 'OPTIONS';

        $response = new Response;

        if (! $options)
        {
            $response = $handler->handle($request);
        }

        return $response->withHeader(self::ORIGIN, $this->allowed)
            ->withHeader(self::METHODS, $this->methods);
    }

    /**
     * Sets the allowed URLS.
     *
     * @param string[] $allowed
     *
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
     * @param string[] $methods
     *
     * @return self
     */
    public function methods($methods)
    {
        $this->methods = $methods;

        return $this;
    }
}
