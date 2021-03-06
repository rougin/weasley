<?php

namespace Rougin\Weasley\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * @param  \Psr\Http\Message\ServerRequestInterface         $request
     * @param  \Interop\Http\ServerMiddleware\DelegateInterface $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $response = $delegate->process($request);

        $new = $response->withHeader('Content-Type', 'application/json');

        return $response->hasHeader('Content-Type') ? $response : $new;
    }
}
