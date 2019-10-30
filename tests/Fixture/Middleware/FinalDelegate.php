<?php

namespace Rougin\Weasley\Fixture\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Final Delegate
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class FinalDelegate implements DelegateInterface
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Initializes the delegate instance.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request)
    {
        return $this->response;
    }
}
