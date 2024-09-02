<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Http\Middleware\Cors;

/**
 * Cross Origin Headers Middleware Test
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CrossOriginHeadersTest extends AbstractTestCase
{
    /**
     * Tests MiddlewareInterface::process.
     *
     * @return void
     */
    public function testProcessMethod()
    {
        $dispatcher = $this->dispatcher->push(new Cors);

        $response = $dispatcher->process($this->request, $this->handler);

        $header = 'Access-Control-Allow-Origin';

        $this->assertTrue($response->hasHeader($header));
    }

    /**
     * Tests MiddlewareInterface::process with allowed methods.
     *
     * @return void
     */
    public function testProcessMethodWithAllowedMethods()
    {
        $dispatcher = $this->dispatcher->push(new Cors);

        $response = $dispatcher->process($this->request, $this->handler);

        $expected = array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS');

        $result = $response->getHeader(Cors::METHODS);

        $this->assertEquals($expected, (array) $result);
    }

    /**
     * Tests MiddlewareInterface::process with allowed origins.
     *
     * @return void
     */
    public function testProcessMethodWithAllowedOrigin()
    {
        $expected = array('https://roug.in', 'google.com.ph');

        $dispatcher = $this->dispatcher->push(new Cors($expected));

        $response = $dispatcher->process($this->request, $this->handler);

        $result = $response->getHeader(Cors::ORIGIN);

        $this->assertEquals($expected, (array) $result);
    }
}
