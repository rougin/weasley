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
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    const DELEGATE = 'Rougin\Weasley\Fixture\Middleware\FinalDelegate';

    const REQUEST = 'Psr\Http\Message\ServerRequestInterface';

    const RESPONSE = 'Psr\Http\Message\ResponseInterface';

    /**
     * @var \Interop\Http\ServerMiddleware\DelegateInterface
     */
    protected $delegate;

    /**
     * @var \Rougin\Slytherin\Middleware\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * Sets up the middleware dispatcher instances.
     *
     * @return void
     */
    public function setUp()
    {
        list($config, $http) = array(new Configuration, new HttpIntegration);

        $container = $http->define(new Container, $config);

        $response = $container->get(self::RESPONSE);

        $this->delegate = new FinalDelegate($response);

        $this->dispatcher = new Dispatcher;

        $this->request = $container->get(self::REQUEST);
    }
}
