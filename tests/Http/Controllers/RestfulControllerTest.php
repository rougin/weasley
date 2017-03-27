<?php

namespace Rougin\Weasley\Http\Controllers;

use Rougin\Weasley\Fixture\Http\Controllers\UsersController;
use Rougin\Weasley\Fixture\Http\Controllers\NoModelController;
use Rougin\Weasley\Fixture\Http\Controllers\NoValidatorController;

class RestfulControllerTest extends TestCase
{
    /**
     * Tests if RestfulController returns an exception if model is not specified.
     *
     * @return void
     */
    public function testNoModelException()
    {
        $this->setExpectedException('UnexpectedValueException');

        $controller = new NoModelController($this->request, $this->response);
    }

    /**
     * Tests if RestfulController returns an exception if validator is not specified.
     *
     * @return void
     */
    public function testNoValidatorException()
    {
        $this->setExpectedException('UnexpectedValueException');

        $controller = new NoValidatorController($this->request, $this->response);
    }

    /**
     * Tests RestfulController::test.
     *
     * @return void
     */
    public function testIndex()
    {
        $controller = new UsersController($this->request, $this->response);

        $items = (string) $controller->index()->getBody();

        $this->assertCount(4, json_decode($items));
    }

    /**
     * Tests RestfulController::show.
     *
     * @return void
     */
    public function testShow()
    {
        $controller = new UsersController($this->request, $this->response);

        $expected = new \stdClass;

        $expected->id       = 1;
        $expected->name     = 'Rougin';
        $expected->password = 'rougin';
        $expected->username = 'rougin';

        $item = (string) $controller->show(1)->getBody();

        $this->assertEquals($expected, json_decode($item));
    }

    /**
     * Tests RestfulController::update.
     *
     * @return void
     */
    public function testUpdate()
    {
        $data = array();

        $data['name']     = 'Test';
        $data['password'] = 'test';
        $data['username'] = 'test';

        $request = $this->request->withParsedBody($data);

        $controller = new UsersController($request, $this->response);

        $expected = new \stdClass;

        $expected->id       = 4;
        $expected->name     = 'Test';
        $expected->password = 'test';
        $expected->username = 'test';

        $result = $controller->update($expected->id);

        $this->assertEquals(204, $result->getStatusCode());
    }

    /**
     * Tests RestfulController::update with validations errors.
     *
     * @return void
     */
    public function testUpdateWithErrors()
    {
        $controller = new UsersController($this->request, $this->response);

        $result = $controller->update(1);

        $expected = new \stdClass;

        $expected->name = array('Name is required');
        $expected->password = array('Password is required');
        $expected->username = array('Username is required');

        $item = (string) $result->getBody();

        $this->assertEquals($expected, json_decode($item));
    }

    /**
     * Tests RestfulController::store.
     *
     * @return void
     */
    public function testStore()
    {
        $data = array();

        $data['name']     = 'Weasley';
        $data['password'] = 'weasley';
        $data['username'] = 'weasley';

        $request = $this->request->withParsedBody($data);

        $controller = new UsersController($request, $this->response);

        $result = (string) $controller->store()->getBody();

        $expected = new \stdClass;

        $expected->id       = 5;
        $expected->name     = 'Weasley';
        $expected->password = 'weasley';
        $expected->username = 'weasley';

        $this->assertEquals($expected, json_decode($result));
    }

    /**
     * Tests RestfulController::store with validations errors.
     *
     * @return void
     */
    public function testStoreWithErrors()
    {
        $controller = new UsersController($this->request, $this->response);

        $result = $controller->store();

        $expected = new \stdClass;

        $expected->name = array('Name is required');
        $expected->password = array('Password is required');
        $expected->username = array('Username is required');

        $item = (string) $result->getBody();

        $this->assertEquals($expected, json_decode($item));
    }

    /**
     * Tests RestfulController::delete.
     *
     * @return void
     */
    public function testDelete()
    {
        $controller = new UsersController($this->request, $this->response);

        $result = $controller->delete(1);

        $this->assertEquals(204, $result->getStatusCode());
    }
}