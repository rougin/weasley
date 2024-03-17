<?php

namespace Rougin\Weasley\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Slytherin\Middleware\HandlerInterface;
use Rougin\Slytherin\Middleware\MiddlewareInterface;

/**
 * JSON Headers Middleware
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class JsonHeaders implements MiddlewareInterface
{
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
        $response = $handler->handle($request);

        $new = $response->withHeader('Content-Type', 'application/json');

        return $response->hasHeader('Content-Type') ? $response : $new;
    }
}
