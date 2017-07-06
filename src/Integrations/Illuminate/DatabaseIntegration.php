<?php

namespace Rougin\Weasley\Integrations\Illuminate;

use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Container\ContainerInterface;

/**
 * Illuminate's Database Integration
 *
 * An integration for Laravel's Eloquent package (illuminate/database).
 *
 * @package Weasley
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

        $default = $config->get('database.default');

        foreach ($config->get('database', array()) as $key => $value) {
            if (is_array($value) === true) {
                $key = ($key === $default) ? 'default' : $key;

                $capsule->addConnection($this->prepare($value), $key);
            }
        }

        $capsule->setAsGlobal() && $capsule->bootEloquent();

        return $container->set('Illuminate\Database\Capsule\Manager', $capsule);
    }

    /**
     * Prepares the database with additional fields.
     *
     * @param  array $database
     * @return array
     */
    protected function prepare(array $database)
    {
        $database['collation'] = 'utf8_unicode_ci';
        $database['prefix'] = '';

        return $database;
    }
}
