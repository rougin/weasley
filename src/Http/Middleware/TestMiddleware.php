<?php

namespace Skeleton\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

/**
 * @package Skeleton
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TestMiddleware implements \Interop\Http\ServerMiddleware\MiddlewareInterface
{
    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface         $request
     * @param  \Interop\Http\ServerMiddleware\DelegateInterface $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        return $delegate->process($request);
    }
}
