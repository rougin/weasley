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
        $expect = array('name' => 'Rougin', 'project' => 'Weasley');

        $http = $this->controller->json($expect);

        $http = $http->getBody()->__toString();

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function testJsonMethodWithError()
    {
        $data = urldecode('bad utf string %C4_');

        $expect = 'null';

        if (defined('JSON_ERROR_UTF8'))
        {
            $expect = 'Malformed UTF-8 characters, possibly incorrectly encoded';
        }

        $http = $this->controller->json($data);

        $actual = $http->getBody()->__toString();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function testToJsonMethod()
    {
        $expect = array('name' => 'Rougin', 'project' => 'Weasley');

        $http = $this->controller->toJson($expect);

        $http = $http->getBody()->__toString();

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }
}
