<?php

namespace Rougin\Weasley\Controllers;

use Rougin\Weasley\Fixture\Controllers\NoModelController;
use Rougin\Weasley\Fixture\Controllers\NoValidatorController;
use Rougin\Weasley\Fixture\Controllers\UsersController;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class JsonControllerTest extends AbstractTestCase
{
    const PAGINATOR = 'Illuminate\Pagination\LengthAwarePaginator';

    /**
     * @var \Rougin\Weasley\Controllers\JsonController
     */
    protected $controller;

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        /** @var \Psr\Http\Message\ResponseInterface */
        $response = $this->container->get(self::RESPONSE);

        /** @var \Psr\Http\Message\ServerRequestInterface */
        $request = $this->container->get(self::REQUEST);

        $this->controller = new UsersController($request, $response);
    }

    /**
     * @return void
     */
    public function testConstructMagicMethodWithoutModel()
    {
        $this->doExpectException('UnexpectedValueException');

        /** @var \Psr\Http\Message\ServerRequestInterface */
        $request = $this->container->get(self::REQUEST);

        /** @var \Psr\Http\Message\ResponseInterface */
        $response = $this->container->get(self::RESPONSE);

        new NoModelController($request, $response);
    }

    /**
     * @return void
     */
    public function testConstructMagicMethodWithoutValidator()
    {
        $this->doExpectException('UnexpectedValueException');

        /** @var \Psr\Http\Message\ServerRequestInterface */
        $request = $this->container->get(self::REQUEST);

        /** @var \Psr\Http\Message\ResponseInterface */
        $response = $this->container->get(self::RESPONSE);

        new NoValidatorController($request, $response);
    }

    /**
     * @return void
     */
    public function testDeleteMethod()
    {
        $expect = 204;

        $response = $this->controller->delete(2);

        $actual = $response->getStatusCode();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function testIndexMethod()
    {
        $http = $this->controller->index();

        $http = $http->getBody()->__toString();

        $expect = 4;

        /** @var array<string, mixed> */
        $actual = json_decode($http, true);

        if (class_exists(self::PAGINATOR))
        {
            /** @var array<integer, mixed> */
            $actual = $actual['items'];
        }

        $this->assertCount($expect, $actual);
    }

    /**
     * @return void
     */
    public function testShowMethod()
    {
        $expect = array('id' => 1, 'name' => 'Rougin');

        $expect['password'] = 'rougin';

        $expect['username'] = 'rougin';

        $http = $this->controller->show(1);

        $http = $http->getBody()->__toString();

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function testShowMethodWithError()
    {
        $expect = '"Specified item not found"';

        $http = $this->controller->show(99);

        $actual = $http->getBody()->__toString();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function testStoreMethod()
    {
        /** @var \Psr\Http\Message\ServerRequestInterface */
        $request = $this->container->get(self::REQUEST);

        $expect = array('id' => 5, 'name' => 'Weasley');

        $expect['username'] = 'weasley';

        $expect['password'] = 'weasley';

        $request = $request->withParsedBody($expect);

        $this->controller->request($request);

        $http = $this->controller->store();

        $http = $http->getBody()->__toString();

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function testStoreMethodWithValidationErrors()
    {
        $expect = array('name' => array('Name is required'));

        $expect['username'] = array('Username is required');

        $expect['password'] = array('Password is required');

        $http = $this->controller->store();

        $http = $http->getBody()->__toString();

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function testUpdateMethod()
    {
        /** @var \Psr\Http\Message\ServerRequestInterface */
        $request = $this->container->get(self::REQUEST);

        $data = array('id' => 4, 'name' => 'Test');

        $data['username'] = 'test';

        $data['password'] = 'test';

        $request = $request->withParsedBody($data);

        $this->controller->request($request);

        $expect = 204;

        $http = $this->controller->update($data['id']);

        $actual = $http->getStatusCode();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function testUpdateMethodWithValidationErrors()
    {
        $expect = array('name' => array('Name is required'));

        $expect['username'] = array('Username is required');

        $expect['password'] = array('Password is required');

        $http = $this->controller->update(1);

        $http = $http->getBody()->__toString();

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }
}
