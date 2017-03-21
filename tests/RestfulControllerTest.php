<?php

namespace Rougin\Weasley;

class RestfulControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Sets up the application.
     *
     * @return void
     */
    public function setUp()
    {
        if (! class_exists('Illuminate\Database\Capsule\Manager')) {
            $this->markTestSkipped('Illuminate\Database is not installed');
        }

        $server = array();

        $server['REQUEST_METHOD']  = 'GET';
        $server['REQUEST_URI']     = '/';
        $server['SERVER_NAME']     = 'localhost';
        $server['SERVER_PORT']     = '8000';

        $this->request  = new \Rougin\Slytherin\Http\ServerRequest($server);
        $this->response = new \Rougin\Slytherin\Http\Response;

        $capsule = new \Illuminate\Database\Capsule\Manager;

        $properties = array();

        $properties['database'] = __DIR__ . '/Fixture/Database.sqlite';
        $properties['driver']   = 'sqlite';
        $properties['prefix']   = '';

        $capsule->addConnection($properties);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * Tests if RestfulController returns an exception if model is not specified.
     *
     * @return void
     */
    public function testNoModelException()
    {
        $this->setExpectedException('UnexpectedValueException');

        $controller = new Fixture\NoModelController($this->request, $this->response);
    }

    /**
     * Tests if RestfulController returns an exception if validator is not specified.
     *
     * @return void
     */
    public function testNoValidatorException()
    {
        $this->setExpectedException('UnexpectedValueException');

        $controller = new Fixture\NoValidatorController($this->request, $this->response);
    }

    /**
     * Tests RestfulController::test.
     *
     * @return void
     */
    public function testIndex()
    {
        $controller = new Fixture\UsersController($this->request, $this->response);

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
        $controller = new Fixture\UsersController($this->request, $this->response);

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

        $controller = new Fixture\UsersController($request, $this->response);

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
        $controller = new Fixture\UsersController($this->request, $this->response);

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

        $controller = new Fixture\UsersController($request, $this->response);

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
        $controller = new Fixture\UsersController($this->request, $this->response);

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
        $controller = new Fixture\UsersController($this->request, $this->response);

        $result = $controller->delete(1);

        $this->assertEquals(204, $result->getStatusCode());
    }
}
