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

        foreach ($config->get('database', array()) as $key => $value) {
            if (is_array($value) === true) {
                $value['collation'] = $config->get("database.$key.collation", 'utf8_unicode_ci');

                $value['prefix'] = $config->get("database.$key.prefix", '');

                $key = ($key === $config->get('database.default')) ? 'default' : $key;

                $capsule->addConnection($value, $key);
            }
        }

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        return $container->set(get_class($capsule), $capsule);
    }
}
