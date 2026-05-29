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
    protected $self;

    /**
     * @return void
     */
    public function test_failed_if_model_not_defined()
    {
        $this->doExpectException('UnexpectedValueException');

        $request = $this->getRequest();

        $response = $this->getResponse();

        new NoModelController($request, $response);
    }

    /**
     * @return void
     */
    public function test_failed_if_validator_not_defined()
    {
        $this->doExpectException('UnexpectedValueException');

        $request = $this->getRequest();

        $response = $this->getResponse();

        new NoValidatorController($request, $response);
    }

    /**
     * @return void
     */
    public function test_passed_if_item_created()
    {
        $request = $this->getRequest();

        $data = array('id' => 5);
        $data['name'] = 'Weasley';
        $data['username'] = 'weasley';
        $data['password'] = 'weasley';

        $request = $request->withParsedBody($data);

        $this->self->request($request);

        $http = $this->self->store();

        $http = $http->getBody()->__toString();

        $expect = $data;

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_item_deleted()
    {
        $expect = 204;

        $http = $this->self->delete(2);

        $actual = $http->getStatusCode();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_item_found()
    {
        $expect = array('id' => 1);
        $expect['name'] = 'Rougin';
        $expect['password'] = 'rougin';
        $expect['username'] = 'rougin';

        $http = $this->self->show(1);

        $http = $http->getBody()->__toString();

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_item_not_found()
    {
        $expect = '"Specified item not found"';

        $http = $this->self->show(99);

        $actual = $http->getBody()->__toString();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_item_updated()
    {
        $request = $this->getRequest();

        $data = array('id' => 4);
        $data['name'] = 'Test';
        $data['username'] = 'test';
        $data['password'] = 'test';

        $request = $request->withParsedBody($data);

        $this->self->request($request);

        $expect = 204;

        $http = $this->self->update($data['id']);

        $actual = $http->getStatusCode();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_items_listed()
    {
        $http = $this->self->index();

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
    public function test_passed_if_validation_fails_on_store()
    {
        $data = array('name' => array());

        $data['name'][] = 'Name is required';

        $data['username'] = array();
        $data['username'][] = 'Username is required';

        $data['password'] = array();
        $data['password'][] = 'Password is required';

        $expect = $data;

        $http = $this->self->store();

        $http = $http->getBody()->__toString();

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_validation_fails_on_update()
    {
        $data = array('name' => array());

        $data['name'][] = 'Name is required';

        $data['username'] = array();
        $data['username'][] = 'Username is required';

        $data['password'] = array();
        $data['password'][] = 'Password is required';

        $expect = $data;

        $http = $this->self->update(1);

        $http = $http->getBody()->__toString();

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $request = $this->getRequest();

        $response = $this->getResponse();

        $self = new UsersController($request, $response);

        $this->self = $self;
    }
}
