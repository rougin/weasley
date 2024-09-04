<?php

namespace App\Integrations;

use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;

/**
 * TestIntegration
 *
 * @package App
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class TestIntegration implements IntegrationInterface
{
    /**
     * Defines the specified package.
     *
     * @param \Rougin\Slytherin\Container\ContainerInterface $container
     * @param \Rougin\Slytherin\Integration\Configuration    $config
     *
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        //

        return $container;
    }
}
