<?php

namespace Rougin\Weasley\Illuminate;

use Rougin\Slytherin\Container\Container;
use Rougin\Weasley\Fixture\Database;
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
    public function test_passed_if_integration_defined()
    {
        $config = Database::config();

        $container = new Container;

        $expect = 'Psr\Container\ContainerInterface';

        $fn = array($this->integration, 'define');

        $fn = array($this->integration, 'define');

        $actual = $fn($container, $config);

        $this->assertInstanceOf($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $class = 'Illuminate\Database\Capsule\Manager';

        if (! class_exists($class))
        {
            $text = 'Illuminate\Database not yet installed.';

            $this->markTestSkipped($text);
        }

        $this->integration = new DatabaseIntegration;
    }
}
