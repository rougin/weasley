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
        $validator = new Fixture\UserValidator;

        $this->assertFalse($validator->validate(array()));
    }
}
