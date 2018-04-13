<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Http\Middleware\Json;

/**
 * JSON Headers Middleware Test
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class JsonHeadersTest extends AbstractTestCase
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
