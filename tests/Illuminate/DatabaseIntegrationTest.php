<?php

namespace Rougin\Weasley\Illuminate;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration;

/**
 * Illuminate Database Integration Test
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DatabaseIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Slytherin\Integration\IntegrationInterface
     */
    protected $integration;

    /**
     * Sets up the integration instance.
     *
     * @return void
     */
    public function setUp()
    {
        $message = 'Illuminate\Database is not yet installed.';

        $class = 'Illuminate\Database\Capsule\Manager';

        class_exists($class) || $this->markTestSkipped($message);

        $this->integration = new DatabaseIntegration;
    }

    /**
     * Tests IntegrationInterface::define.
     *
     * @return void
     */
    public function testDefineMethod()
    {
        $path = __DIR__ . '/../Fixture/Database.sqlite';

        $container = new Container;

        $config = new Configuration;

        $config->set('database.default', 'sqlite');
        $config->set('database.sqlite.driver', 'sqlite');
        $config->set('database.sqlite.database', $path);

        $expected = 'Psr\Container\ContainerInterface';

        $result = $this->integration->define($container, $config);

        $this->assertInstanceOf($expected, $result);
    }
}
