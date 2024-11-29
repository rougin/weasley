<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Http\Middleware\Json;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class JsonHeadersTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testProcessMethod()
    {
        $dispatcher = $this->dispatcher->push(new Json);

        $response = $dispatcher->process($this->request, $this->handler);

        $expected = array('application/json');

        $result = $response->getHeader('Content-Type');

        $this->assertEquals($expected, $result);
    }
}
