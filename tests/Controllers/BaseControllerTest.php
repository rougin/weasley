<?php

namespace Rougin\Weasley\Controllers;

/**
 * Base Controller Test
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
    public function setUp()
    {
        parent::setUp();

        $response = $this->container->get(self::RESPONSE);

        $request = $this->container->get(self::REQUEST);

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
     * NOTE: Must be removed in v1.0.0. Use "json" instead.
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
