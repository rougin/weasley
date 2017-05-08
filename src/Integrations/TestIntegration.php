<?php

namespace Skeleton\Integrations;

use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Container\ContainerInterface;

/**
 * @package Skeleton
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TestIntegration implements \Rougin\Slytherin\Integration\IntegrationInterface
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
        //

        return $container;
    }
}
