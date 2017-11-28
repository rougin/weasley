<?php

namespace Rougin\Weasley\Integrations\Illuminate;

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
    /**
     * Defines the specified integration.
     *
     * @param  \Rougin\Slytherin\Container\ContainerInterface $container
     * @param  \Rougin\Slytherin\Integration\Configuration    $config
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        $request = $container->get('Psr\Http\Message\ServerRequestInterface');

        Paginator::currentPathResolver(function () use ($request) {
            $uri = $request->getAttribute('REQUEST_URI');

            return isset($uri) ? strtok($uri, '?') : '/';
        });

        Paginator::currentPageResolver(function ($name = null) use ($request) {
            $parameters = $request->getQueryParams();

            $name = $name ?: 'page';

            return isset($parameters[$name]) ? $parameters[$name] : 1;
        });

        return $container;
    }
}
