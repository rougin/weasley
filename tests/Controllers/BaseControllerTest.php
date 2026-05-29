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
    protected $self;

    /**
     * @return void
     */
    public function test_passed_if_json_encoded()
    {
        $data = array('name' => 'Rougin');

        $data['project'] = 'Weasley';

        $http = $this->self->json($data);

        $http = $http->getBody()->__toString();

        $expect = $data;

        $actual = json_decode($http, true);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_json_error_handled()
    {
        $data = urldecode('bad utf string %C4_');

        $expect = 'null';

        if (defined('JSON_ERROR_UTF8'))
        {
            $expect = 'Malformed UTF-8 characters';

            $expect .= ', possibly incorrectly encoded';
        }

        $http = $this->self->json($data);

        $actual = $http->getBody()->__toString();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_to_json_used()
    {
        $data = array('name' => 'Rougin');

        $data['project'] = 'Weasley';

        $http = $this->self->toJson($data);

        $http = $http->getBody()->__toString();

        $expect = $data;

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

        $class = 'Rougin\Weasley\Controllers\BaseController';

        $this->self = new $class($request, $response);
    }
}
