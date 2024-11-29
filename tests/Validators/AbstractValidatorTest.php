<?php

namespace Rougin\Weasley\Validators;

use Rougin\Weasley\Fixture\Validators\UserValidator;
use Rougin\Weasley\Testcase;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class AbstractValidatorTest extends Testcase
{
    /**
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
