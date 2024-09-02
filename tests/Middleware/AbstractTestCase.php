<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Http\HttpIntegration;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Middleware\Dispatcher;
use Rougin\Weasley\Fixture\Middleware\FinalDelegate;

/**
 * Abstract Test Case
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \Rougin\Weasley\Testcase
{
    const DELEGATE = 'Rougin\Weasley\Fixture\Middleware\FinalDelegate';

    const REQUEST = 'Psr\Http\Message\ServerRequestInterface';

    const RESPONSE = 'Psr\Http\Message\ResponseInterface';

    /**
     * @var \Rougin\Slytherin\Middleware\HandlerInterface
     */
    protected $handler;

    /**
     * @var \Rougin\Slytherin\Middleware\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * Sets up the middleware dispatcher instances.
     *
     * @return void
     */
    protected function doSetUp()
    {
        list($config, $http) = array(new Configuration, new HttpIntegration);

        $container = $http->define(new Container, $config);

        /** @var \Psr\Http\Message\ResponseInterface */
        $response = $container->get(self::RESPONSE);

        $this->handler = new FinalDelegate($response);

        $this->dispatcher = new Dispatcher;

        /** @var \Psr\Http\Message\ServerRequestInterface */
        $request = $container->get(self::REQUEST);

        $this->request = $request;
    }
}
