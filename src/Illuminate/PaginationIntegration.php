<?php

namespace Rougin\Weasley\Illuminate;

use Illuminate\Pagination\Paginator;
use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;

/**
 * Illuminate's Pagination Integration
 *
 * An integration for Laravel's Pagination package (illuminate/pagination).
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class PaginationIntegration implements IntegrationInterface
{
    const SERVER_REQUEST = 'Psr\Http\Message\ServerRequestInterface';

    /**
     * Defines the specified integration.
     *
     * @param  \Rougin\Slytherin\Container\ContainerInterface $container
     * @param  \Rougin\Slytherin\Integration\Configuration    $config
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        list($query, $request) = $this->request($container);

        $page = function ($name = null) use ($query) {
            $name = $name === null ? 'page' : $name;

            return isset($query[$name]) ? $query[$name] : 1;
        };

        $path = function () use ($request) {
            $uri = $request->getAttribute('REQUEST_URI');

            return isset($uri) ? strtok($uri, '?') : '/';
        };

        $this->resolve($page, $path);

        return $container;
    }

    /**
     * Returns the REQUEST_URI and ServerRequest instances.
     *
     * @param  \Rougin\Slytherin\Container\ContainerInterface $container
     * @return array
     */
    protected function request(ContainerInterface $container)
    {
        $request = $container->get(self::SERVER_REQUEST);

        return array($request->getQueryParams(), $request);
    }

    /**
     * Sets current page and path resolvers.
     *
     * @param  callable $page
     * @param  callable $path
     * @return void
     */
    protected function resolve($page, $path)
    {
        Paginator::currentPageResolver($page);

        Paginator::currentPathResolver($path);
    }
}
