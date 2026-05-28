<?php

namespace Rougin\Weasley\Controllers;

use Illuminate\Database\Capsule\Manager;
use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Http\HttpIntegration;
use Rougin\Weasley\Fixture\Database;
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

        $config = Database::config();

        $eloquent = new DatabaseIntegration;

        $http = new HttpIntegration;

        $container = $eloquent->define(new Container, $config);

        $pdo = Manager::connection()->getPdo();

        Database::migrate($pdo);

        Database::seed($pdo);

        $this->container = $http->define($container, $config);
    }
}
