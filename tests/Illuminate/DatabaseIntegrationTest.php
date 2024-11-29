<?php

namespace Rougin\Weasley\Illuminate;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Weasley\Testcase;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DatabaseIntegrationTest extends Testcase
{
    /**
     * @var \Rougin\Slytherin\Integration\IntegrationInterface
     */
    protected $integration;

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $message = 'Illuminate\Database is not yet installed.';

        $class = 'Illuminate\Database\Capsule\Manager';

        class_exists($class) || $this->markTestSkipped($message);

        $this->integration = new DatabaseIntegration;
    }

    /**
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
