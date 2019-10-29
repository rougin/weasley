<?php

namespace Rougin\Weasley\Fixture\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * @param  \Psr\Http\Message\ServerRequestInterface         $request
     * @param  \Interop\Http\ServerMiddleware\DelegateInterface $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $response = $delegate->process($request);

        $query = $request->getQueryParams();

        $key = 'Trimmed-Query-Params';

        return $response->withHeader($key, $query);
    }
}
