<?php

namespace Rougin\Weasley\Http\Controllers;

use Rougin\LoreamAuthsum\Checker\EloquentChecker;

class AuthenticationControllerTest extends TestCase
{
    /**
     * Tests AuthenticationController::validate
     *
     * @return void
     */
    public function testLogin()
    {
        $checker = new EloquentChecker('Rougin\Weasley\Fixture\Models\User');

        $checker->setHashing(false);

        $data = array();

        $data['username'] = 'rougin';
        $data['password'] = 'rougin';

        $request = $this->request->withParsedBody($data);

        $controller = new AuthenticationController($checker, $request, $this->response);

        $result = $controller->login();

        $this->assertEquals(200, $result->getStatusCode());
    }

    /**
     * Tests AuthenticationController::validate
     *
     * @return void
     */
    public function testValidate()
    {
        $checker = new EloquentChecker('Rougin\Weasley\Fixture\UserModel');

        $controller = new AuthenticationController($checker, $this->request, $this->response);

        $result = $controller->login()->getBody();
        $result = json_decode((string) $result);

        $this->assertEquals('Username is required', $result->validation->username[0]);
    }
}
