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
    protected $app;

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

        $config = Database::config();

        $eloquent = new DatabaseIntegration;

        $http = new HttpIntegration;

        $app = new Container;

        $app = $eloquent->define($app, $config);

        $pdo = Manager::connection()->getPdo();

        Database::migrate($pdo);

        Database::seed($pdo);

        $this->app = $http->define($app, $config);
    }

    /**
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    protected function getRequest()
    {
        /** @var \Psr\Http\Message\ServerRequestInterface */
        return $this->app->get(self::REQUEST);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function getResponse()
    {
        /** @var \Psr\Http\Message\ResponseInterface */
        return $this->app->get(self::RESPONSE);
    }
}
