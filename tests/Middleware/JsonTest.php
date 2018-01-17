<?php

namespace Rougin\Weasley\Middleware;

/**
 * JSON Middleware Test
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class JsonTest extends AbstractTestCase
{
    /**
     * Tests MiddlewareInterface::process.
     *
     * @return void
     */
    public function testProcessMethod()
    {
        $dispatcher = $this->dispatcher->push(new Json);

        $response = $dispatcher->process($this->request, $this->delegate);

        $expected = array('application/json');

        $result = $response->getHeader('Content-Type');

        $this->assertEquals($expected, $result);
    }
}
