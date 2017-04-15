<?php

namespace Rougin\Weasley;

class IntegrationsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Illuminate\DatabaseIntegration.
     *
     * @return void
     */
    public function testIlluminateDatabase()
    {
        $container = new \Rougin\Slytherin\Container\Container;

        $config = new \Rougin\Slytherin\Integration\Configuration;

        $integration = new Integrations\Illuminate\DatabaseIntegration;

        $interface = 'Psr\Container\ContainerInterface';

        $this->assertInstanceOf($interface, $integration->define($container, $config));
    }
}
