<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Http\Middleware\Cors;

/**
 * Cross Origin Headers Middleware Test
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
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

        $response = $dispatcher->process($this->request, $this->delegate);

        $header = 'Access-Control-Allow-Origin';

        $this->assertTrue($response->hasHeader($header));
    }

    /**
     * Tests MiddlewareInterface::process with OPTIONS HTTP method.
     *
     * @return void
     */
    public function testProcessMethodWithOptionHttpMethod()
    {
        $this->request = $this->request->withMethod('OPTIONS');

        $dispatcher = $this->dispatcher->push(new Cors);

        $response = $dispatcher->process($this->request, $this->delegate);

        $header = 'Access-Control-Allow-Origin';

        $this->assertFalse($response->hasHeader($header));
    }
}
