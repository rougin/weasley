<?php

namespace Rougin\Weasley\Middleware;

use Rougin\Weasley\Fixture\Middleware\CheckPatchMethod;

/**
 * "Form Method Spoofing" Middleware Test
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class FormMethodSpoofingTest extends AbstractTestCase
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

        $this->dispatcher->push(new FormMethodSpoofing('_test'));

        $dispatcher = $this->dispatcher->push(new CheckPatchMethod);

        $response = $dispatcher->process($request, $this->delegate);

        $expected = array(true);

        $result = $response->getHeader('Weasley-Has-PATCH-Method');

        $this->assertEquals($expected, $result);
    }
}
