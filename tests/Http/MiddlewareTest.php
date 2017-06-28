<?php

namespace Rougin\Weasley\Http;

class MiddlewareTest extends \PHPUnit_Framework_TestCase
{
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
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI']    = '/';
        $_SERVER['SERVER_NAME']    = 'localhost';
        $_SERVER['SERVER_PORT']    = '8000';

        $middleware = new \Rougin\Slytherin\Middleware\Middleware;
        $request = new \Rougin\Slytherin\Http\ServerRequest($_SERVER);
        $response = new \Rougin\Slytherin\Http\Response;

        $request = $request->withParsedBody(array('_method' => 'PUT'));

        $stack = array();

        array_push($stack, 'Rougin\Weasley\Http\Middleware\Json');
        array_push($stack, 'Rougin\Weasley\Http\Middleware\Cors');
        array_push($stack, 'Rougin\Slytherin\Middleware\FinalResponse');

        $this->response = $middleware($request, $response, $stack);
    }

    /**
     * Tests Rougin\Weasley\Http\Middleware\Json.
     *
     * @return void
     */
    public function testJson()
    {
        $result = $this->response->getHeader('Content-Type');

        $this->assertEquals(array('application/json'), $result);
    }

    /**
     * Tests Rougin\Weasley\Http\Middleware\Cors.
     *
     * @return void
     */
    public function testCors()
    {
        $result = $this->response->hasHeader('Access-Control-Allow-Origin');

        $this->assertTrue($result);
    }

    /**
     * Tests Rougin\Weasley\Http\Middleware\FormMethodSpoofing.
     *
     * @return void
     */
    public function testFormMethodSpoofing()
    {
        $this->assertEquals('PUT', $this->response->getMethod());
    }
}
