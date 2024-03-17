<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Fixture\Middleware\CheckPatchMethod;

/**
 * Spoof Form Method Middleware Test
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class SpoofFormMethodTest extends AbstractTestCase
{
    /**
     * Tests MiddlewareInterface::process.
     *
     * @return void
     */
    public function testProcessMethod()
    {
        $data = array('_test' => 'PATCH', 'name' => 'Weasley');

        $request = $this->request->withParsedBody($data);

        $this->dispatcher->push(new SpoofFormMethod('_test'));

        $dispatcher = $this->dispatcher->push(new CheckPatchMethod);

        $response = $dispatcher->process($request, $this->handler);

        $expected = array('true');

        $result = $response->getHeader('Weasley-Has-PATCH-Method');

        $this->assertEquals($expected, $result);
    }
}
