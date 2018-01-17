<?php

namespace Rougin\Weasley\Controllers;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Http\HttpIntegration;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Weasley\Illuminate\DatabaseIntegration;

/**
 * Abstract Test Case
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    const REQUEST = 'Psr\Http\Message\ServerRequestInterface';

    const RESPONSE = 'Psr\Http\Message\ResponseInterface';

    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * Sets up the request and response instances.
     *
     * @return void
     */
    public function setUp()
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
