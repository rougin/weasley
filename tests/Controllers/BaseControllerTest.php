<?php

namespace Rougin\Weasley\Controllers;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class BaseControllerTest extends AbstractTestCase
{
    /**
     * @var \Rougin\Weasley\Controllers\BaseController
     */
    protected $controller;

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        /** @var \Psr\Http\Message\ServerRequestInterface */
        $request = $this->container->get(self::REQUEST);

        /** @var \Psr\Http\Message\ResponseInterface */
        $response = $this->container->get(self::RESPONSE);

        $this->controller = new BaseController($request, $response);
    }

    /**
     * @return void
     */
    public function testJsonMethod()
    {
        $expected = array('name' => 'Rougin', 'project' => 'Weasley');

        $response = $this->controller->json($expected);

        $result = json_decode((string) $response->getBody(), true);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testJsonMethodWithError()
    {
        $data = urldecode('bad utf string %C4_');

        $expected = 'Malformed UTF-8 characters, possibly incorrectly encoded';

        $response = $this->controller->json($data);

        $result = (string) $response->getBody();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testToJsonMethod()
    {
        $expected = array('name' => 'Rougin', 'project' => 'Weasley');

        $response = $this->controller->toJson($expected);

        $result = json_decode((string) $response->getBody(), true);

        $this->assertEquals($expected, $result);
    }
}
