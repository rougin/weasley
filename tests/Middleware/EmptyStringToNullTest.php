<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Fixture\Middleware\CheckQueryParams;

/**
 * "Empty String To Null" Middleware Test
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class EmptyStringToNullTest extends AbstractTestCase
{
    /**
     * Tests MiddlewareInterface::process.
     *
     * @return void
     */
    public function testProcessMethod()
    {
        $query = array('age' => '', 'address' => '');

        $request = $this->request->withQueryParams($query);

        $this->dispatcher->push(new EmptyStringToNull);

        $dispatcher = $this->dispatcher->push(new CheckQueryParams);

        $response = $dispatcher->process($request, $this->delegate);

        $expected = array('age' => null, 'address' => null);

        $result = $response->getHeader('Cleaned-Query-Params');

        $this->assertEquals($expected, $result);
    }
}
