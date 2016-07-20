<?php

namespace {{ application }}\{{ namespaces.middlewares }};

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * {{ name | title }} Middleware
 *
 * @package {{ application }}
 * @author  {{ author }} <{{ email }}>
 */
class {{ name | title }}Middleware
{
    /**
     * @param  \Psr\Http\Message\ServerRequestInterface $request
     * @param  \Psr\Http\Message\ResponseInterface      $response
     * @param  callable|null $next
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        //
    }
}
