<?php

namespace Rougin\Weasley\Packages\Laravel;

use Illuminate\Database\Capsule\Manager;
use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Eloquent implements IntegrationInterface
{
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
        $capsule = new Manager;

        /** @var array<string, mixed> */
        $items = $config->get('database', array());

        foreach ($items as $key => $item)
        {
            if (is_array($item))
            {
                /** @var array<string, mixed> $item */
                $this->connection($config, $key, $item);

                $capsule->addConnection($item, $key);
            }
        }

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        return $container->set(get_class($capsule), $capsule);
    }

    /**
     * Updates the parameters of the current connection.
     *
     * @param \Rougin\Slytherin\Integration\Configuration $config
     * @param string                                      $key
     * @param array<string, mixed>                        $value
     *
     * @return void
     */
    protected function connection(Configuration $config, &$key, &$value)
    {
        $collation = 'database.' . $key . '.collation';

        /** @var string */
        $collation = $config->get($collation, 'utf8_unicode_ci');

        $value['collation'] = $collation;

        $prefix = 'database.' . $key . '.prefix';

        $value['prefix'] = $config->get($prefix, '');

        $default = $key === $config->get('database.default');

        $key = $default ? 'default' : $key;
    }
}
