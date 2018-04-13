<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Fixture\Middleware\ReturnQueryParams;

/**
 * Transform Request Middleware Test
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TransformRequestTest extends AbstractTestCase
{
    /**
     * Tests MiddlewareInterface::process.
     *
     * @return void
     */
    public function testProcessMethod()
    {
        $expected = array('name' => 'Rougin', 'address' => 'Secret');

        $request = $this->request->withQueryParams($expected);

        $this->dispatcher->push(new TransformRequest);

        $dispatcher = $this->dispatcher->push(new ReturnQueryParams);

        $response = $dispatcher->process($request, $this->delegate);

        $result = $response->getHeader('Query-Params');

        $this->assertEquals($expected, (array) $result);
    }
}
