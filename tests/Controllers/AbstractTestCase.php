<?php

namespace Rougin\Weasley\Controllers;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Http\HttpIntegration;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Weasley\Illuminate\DatabaseIntegration;
use Rougin\Weasley\Testcase;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends Testcase
{
    const REQUEST = 'Psr\Http\Message\ServerRequestInterface';

    const RESPONSE = 'Psr\Http\Message\ResponseInterface';

    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $message = 'Illuminate\Database is not yet installed.';

        $class = 'Illuminate\Database\Capsule\Manager';

        class_exists($class) || $this->markTestSkipped($message);

        list($config, $path) = array(new Configuration, '');

        $path = __DIR__ . '/../Fixture/Database.sqlite';

        $config->set('database.default', 'sqlite');
        $config->set('database.sqlite.database', $path);
        $config->set('database.sqlite.driver', 'sqlite');
        $config->set('database.sqlite.prefix', '');

        $eloquent = new DatabaseIntegration;

        $http = new HttpIntegration;

        $container = $eloquent->define(new Container, $config);

        $this->container = $http->define($container, $config);
    }
}
