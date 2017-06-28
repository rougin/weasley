<?php

namespace Support\Manager\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

/**
 * Form Method Spoofing Middleware
 *
 * @package Manager
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class FormMethodSpoofing implements \Interop\Http\ServerMiddleware\MiddlewareInterface
{
    /**
     * @var string
     */
    protected $identifier = '_method';

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
        $parsed = $request->getParsedBody();

        if (isset($parsed[$this->identifier])) {
            $method = $parsed[$this->identifier];

            $request = $request->withMethod($method);
        }

        return $delegate->process($request);
    }
}