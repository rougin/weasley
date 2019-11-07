<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Fixture\Middleware\CheckTrimmedString;

/**
 * Trim String Middleware Test
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class TrimStringTest extends AbstractTestCase
{
    /**
     * Tests MiddlewareInterface::process.
     *
     * @return void
     */
    public function testProcessMethod()
    {
        $query = array('name' => 'Rougin  ', 'address' => '  Secret');

        $request = $this->request->withQueryParams($query);

        $this->dispatcher->push(new TrimString);

        $dispatcher = $this->dispatcher->push(new CheckTrimmedString);

        $response = $dispatcher->process($request, $this->delegate);

        $expected = array('name' => 'Rougin', 'address' => 'Secret');

        $result = $response->getHeader('Trimmed-Query-Params');

        $this->assertEquals($expected, $result);
    }
}
