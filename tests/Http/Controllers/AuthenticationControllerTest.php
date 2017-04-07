<?php

namespace Rougin\Weasley\Http\Controllers;

use Rougin\LoreamAuthsum\Checker\EloquentChecker;

class AuthenticationControllerTest extends TestCase
{
    /**
     * Tests AuthenticationController::login
     *
     * @return void
     */
    public function testLogin()
    {
        $checker = new EloquentChecker('Rougin\Weasley\Fixture\Models\User');

        $checker->setHashing(false);

        $data = array('username' => 'rougin', 'password' => 'rougin');

        $request = $this->request->withParsedBody($data);

        $controller = new AuthenticationController($checker, $request, $this->response);

        $this->assertEquals(200, $controller->login()->getStatusCode());
    }

    /**
     * Tests AuthenticationController::validate
     *
     * @return void
     */
    public function testValidate()
    {
        $checker = new EloquentChecker('Rougin\Weasley\Fixture\Models\User');

        $controller = new AuthenticationController($checker, $this->request, $this->response);

        $result = json_decode((string) $controller->login()->getBody());

        $this->assertEquals('Username is required', $result->validation->username[0]);
    }
}
