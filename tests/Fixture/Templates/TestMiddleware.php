<?php

namespace App\Http\Middleware;

use Rougin\Slytherin\Middleware\HandlerInterface;
use Rougin\Slytherin\Middleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * TestMiddleware
 *
 * @package App
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class TestMiddleware implements MiddlewareInterface
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
        //

        return $handler->handle($request);
    }
}
