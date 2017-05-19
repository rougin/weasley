<?php

namespace Rougin\Weasley\Http\Controllers;

class BaseControllerTest extends TestCase
{
    /**
     * Tests BaseController::json.
     *
     * @return void
     */
    public function testJson()
    {
        $data = array('name' => 'Rougin', 'project' => 'Weasley');

        $controller = new BaseController($this->request, $this->response);

        $response = $controller->json($data);

        $this->assertEquals(json_encode($data), (string) $response->getBody());
    }

    /**
     * Tests BaseController::json with an error.
     *
     * @return void
     */
    public function testJsonWithError()
    {
        $expected = 'Malformed UTF-8 characters, possibly incorrectly encoded';

        $data = urldecode('bad utf string %C4_');

        $controller = new BaseController($this->request, $this->response);

        $response = $controller->json($data);

        $this->assertEquals($expected, (string) $response->getBody());
    }
}
