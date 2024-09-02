<?php

namespace Rougin\Weasley\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Slytherin\Middleware\HandlerInterface;
use Rougin\Slytherin\Middleware\MiddlewareInterface;

/**
 * JSON Content Type Middleware
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class JsonContentType implements MiddlewareInterface
{
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
        $response = $handler->handle($request);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
