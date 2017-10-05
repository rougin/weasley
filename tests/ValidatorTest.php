<?php

namespace Rougin\Weasley;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests AbstractValidator::validate.
     *
     * @return void
     */
    public function testValidate()
    {
        $validator = new Fixture\Validators\UserValidator;

        $data = array('name' => 'Rougin', 'username' => 'rougin', 'password' => '12345');

        $this->assertTrue($validator->validate($data));
    }
}
