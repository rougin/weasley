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
        $this->setExpectedException('UnexpectedValueException');

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
        $this->setExpectedException('UnexpectedValueException');

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
        $expected = 204;

        $response = $this->controller->delete(2);

        $result = $response->getStatusCode();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testIndexMethod()
    {
        $response = $this->controller->index();

        $response = $response->getBody();

        $expected = 4 - 1; // Because of testDeleteMethod

        /** @var array<string, mixed> */
        $result = json_decode((string) $response, true);

        if (class_exists(self::PAGINATOR))
        {
            /** @var array<integer, mixed> */
            $result = $result['items'];
        }

        $this->assertCount($expected, $result);
    }

    /**
     * @return void
     */
    public function testShowMethod()
    {
        $expected = array('id' => 1, 'name' => 'Rougin');

        $expected['password'] = 'rougin';

        $expected['username'] = 'rougin';

        $response = $this->controller->show(1)->getBody();

        $result = json_decode((string) $response, true);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testShowMethodWithError()
    {
        $expected = '"Specified item not found"';

        $response = $this->controller->show(99);

        $result = (string) $response->getBody();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testStoreMethod()
    {
        /** @var \Psr\Http\Message\ServerRequestInterface */
        $request = $this->container->get(self::REQUEST);

        $expected = array('id' => 5, 'name' => 'Weasley');

        $expected['username'] = 'weasley';

        $expected['password'] = 'weasley';

        $request = $request->withParsedBody($expected);

        $this->controller->request($request);

        $response = $this->controller->store()->getBody();

        $result = json_decode((string) $response, true);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testStoreMethodWithValidationErrors()
    {
        $response = $this->controller->store()->getBody();

        $expected = array('name' => array('Name is required'));

        $expected['username'] = array('Username is required');

        $expected['password'] = array('Password is required');

        $result = json_decode((string) $response, true);

        $this->assertEquals($expected, $result);
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

        $expected = 204;

        $response = $this->controller->update($data['id']);

        $result = $response->getStatusCode();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testUpdateMethodWithValidationErrors()
    {
        $response = $this->controller->update(1)->getBody();

        $expected = array('name' => array('Name is required'));

        $expected['username'] = array('Username is required');

        $expected['password'] = array('Password is required');

        $result = json_decode((string) $response, true);

        $this->assertEquals($expected, $result);
    }
}
