<?php

namespace Rougin\Weasley\Integrations\Illuminate;

use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Container\ContainerInterface;

use Illuminate\Pagination\Paginator;

/**
 * Illuminate's Pagination Integration
 *
 * An integration for Laravel's Pagination package (illuminate/pagination).
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class PaginationIntegration implements \Rougin\Slytherin\Integration\IntegrationInterface
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

        $response = $container->get('Psr\Http\Message\ResponseInterface');

        Paginator::currentPathResolver(function () use ($request) {
            $uri = $request->getAttribute('REQUEST_URI');

            return isset($uri) ? strtok($uri, '?') : '/';
        });

        Paginator::currentPageResolver(function ($name = null) use ($request) {
            list($page, $parameters) = array($name ?: 'page', $request->getQueryParams());

            return isset($parameters[$name]) ? $parameters[$name] : 1;
        });

        return $container;
    }
}
