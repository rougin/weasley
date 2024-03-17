<?php

namespace Rougin\Weasley\Illuminate;

use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;

/**
 * Illuminate's Database Integration
 *
 * An integration for Laravel's Eloquent package (illuminate/database).
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class DatabaseIntegration implements IntegrationInterface
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

        $connections = $config->get('database', array());

        foreach ((array) $connections as $key => $value)
        {
            if (is_array($value) === true)
            {
                $this->connection($config, $key, $value);

                $capsule->addConnection($value, $key);
            }
        }

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        return $container->set(get_class($capsule), $capsule);
    }

    /**
     * Updates the parameters of the current connection.
     *
     * @param  \Rougin\Slytherin\Integration\Configuration $config
     * @param  string                                      $key
     * @param  array                                       $value
     * @return void
     */
    protected function connection(Configuration $config, &$key, &$value)
    {
        $collation = 'database.' . $key . '.collation';

        $value['collation'] = $config->get($collation, 'utf8_unicode_ci');

        $prefix = 'database.' . $key . '.prefix';

        $value['prefix'] = $config->get($prefix, '');

        $key === $config->get('database.default') && $key = 'default';
    }
}
