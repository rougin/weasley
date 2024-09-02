<?php

namespace Rougin\Weasley\Packages\Laravel;

use Illuminate\Pagination\Paginator;
use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;

/**
 * Laravel Pagination Integration
 *
 * An integration for the Laravel Pagination package (illuminate/pagination).
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Paginate implements IntegrationInterface
{
    const REQUEST = 'Psr\Http\Message\ServerRequestInterface';

    /**
     * Defines the specified integration.
     *
     * @param \Rougin\Slytherin\Container\ContainerInterface $container
     * @param \Rougin\Slytherin\Integration\Configuration    $config
     *
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        /** @var \Psr\Http\Message\ServerRequestInterface */
        $request = $container->get(self::REQUEST);

        $query = $request->getQueryParams();

        $page = function ($name = null) use ($query)
        {
            $name = $name === null ? 'page' : $name;

            return isset($query[$name]) ? $query[$name] : 1;
        };

        $path = function () use ($request)
        {
            /** @var string|null */
            $uri = $request->getAttribute('REQUEST_URI');

            return $uri ? strtok($uri, '?') : '/';
        };

        $this->resolve($page, $path);

        return $container;
    }

    /**
     * Sets current page and path resolvers.
     *
     * @param \Closure $page
     * @param \Closure $path
     *
     * @return void
     */
    protected function resolve($page, $path)
    {
        Paginator::currentPageResolver($page);

        Paginator::currentPathResolver($path);
    }
}
