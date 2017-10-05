<?php

namespace Rougin\Weasley\Http\Controllers;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Sets up the application.
     *
     * @return void
     */
    public function setUp()
    {
        if (! class_exists('Illuminate\Database\Capsule\Manager')) {
            $this->markTestSkipped('Illuminate\Database is not installed');
        }

        $server = array();

        $server['REQUEST_METHOD']  = 'GET';
        $server['REQUEST_URI']     = '/';
        $server['SERVER_NAME']     = 'localhost';
        $server['SERVER_PORT']     = '8000';

        $this->request  = new \Rougin\Slytherin\Http\ServerRequest($server);
        $this->response = new \Rougin\Slytherin\Http\Response;

        $capsule = new \Illuminate\Database\Capsule\Manager;

        $properties = array();

        $properties['database'] = __DIR__ . '/../../Fixture/Database.sqlite';
        $properties['driver'] = 'sqlite';
        $properties['prefix'] = '';

        $capsule->addConnection($properties);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
