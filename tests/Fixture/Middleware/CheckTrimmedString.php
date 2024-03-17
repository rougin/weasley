<?php

namespace Rougin\Weasley\Fixture\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Slytherin\Middleware\HandlerInterface;
use Rougin\Slytherin\Middleware\MiddlewareInterface;

/**
 * "Check Trimmed String" Middleware
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CheckTrimmedString implements MiddlewareInterface
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

        $query = $request->getQueryParams();

        $key = 'Trimmed-Query-Params';

        return $response->withHeader($key, $query);
    }
}
