<?php

namespace Rougin\Weasley\Controllers;

/**
 * Base Controller Test
 *
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
     * Sets up the controller instance.
     *
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
     * Tests BaseController::json.
     *
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
     * Tests BaseController::json with an error.
     *
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
     * Tests BaseController::toJson.
     *
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
