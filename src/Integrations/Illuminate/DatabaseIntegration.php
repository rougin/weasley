<?php

namespace Rougin\Weasley\Integrations\Illuminate;

use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Container\ContainerInterface;

/**
 * Illuminate's Database Integration
 *
 * An integration for Laravel's Eloquent package (illuminate/database).
 *
 * @package Skeleton
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DatabaseIntegration implements \Rougin\Slytherin\Integration\IntegrationInterface
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
        $capsule = new \Illuminate\Database\Capsule\Manager;

        $database = $config->get('database');

        $database['charset'] = 'utf8';
        $database['collation'] = 'utf8_unicode_ci';
        $database['prefix'] = '';

        $capsule->addConnection($database);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $container;
    }
}
