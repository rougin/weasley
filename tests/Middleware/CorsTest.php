<?php

namespace Rougin\Weasley\Middleware;

/**
 * CORS Middleware Test
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CorsTest extends AbstractTestCase
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
}
