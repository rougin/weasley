<?php

namespace Rougin\Weasley\Fixture\Middleware;

use Rougin\Slytherin\Middleware\HandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Final Delegate
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class FinalDelegate implements HandlerInterface
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Initializes the handler instance.
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
    public function handle(ServerRequestInterface $request)
    {
        return $this->response;
    }
}
