<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Fixture\Middleware\ReturnQueryParams;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class TransformRequestTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testProcessMethod()
    {
        $expected = array('name' => 'Rougin', 'address' => 'Secret');

        $request = $this->request->withQueryParams($expected);

        $this->dispatcher->push(new TransformRequest);

        $dispatcher = $this->dispatcher->push(new ReturnQueryParams);

        $response = $dispatcher->process($request, $this->handler);

        $result = $response->getHeader('Query-Params');

        $this->assertEquals($expected, (array) $result);
    }
}
