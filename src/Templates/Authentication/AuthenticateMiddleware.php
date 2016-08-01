<?php

namespace {{ application.name }}\{{ namespaces.middlewares }};

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Authenticate Middleware
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class AuthenticateMiddleware
{
    /**
     * @param  \Psr\Http\Message\ServerRequestInterface $request
     * @param  \Psr\Http\Message\ResponseInterface      $response
     * @param  callable|null $next
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if ( ! isset($_SESSION['{{ model }}'])) {
            return redirect('sign-in?url=' . $request->getUri()->getPath());
        }

        return $next($request, $response);
    }
}
