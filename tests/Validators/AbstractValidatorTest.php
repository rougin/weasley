<?php

namespace Rougin\Weasley;

use Rougin\Weasley\Fixture\Validators\UserValidator;

/**
 * Abstract Validator Test
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class AbstractValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests AbstractValidator::validate.
     *
     * @return void
     */
    public function testValidateMethod()
    {
        $validator = new UserValidator;

        $data = array('name' => 'Rougin');

        $data['username'] = 'rougin';

        $data['password'] = '12345';

        $result = $validator->validate($data);

        $this->assertTrue($result);
    }
}
