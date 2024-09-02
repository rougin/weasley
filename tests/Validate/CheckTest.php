<?php

namespace Rougin\Weasley;

use Rougin\Weasley\Fixture\Checks\UserCheck;
use Rougin\Weasley\Fixture\Checks\UserCheckWithData;

/**
 * Check Test
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CheckTest extends Testcase
{
    /**
     * @return void
     */
    public function test_passed_validation()
    {
        $check = new UserCheck;

        $data = array('name' => 'Rougin');

        $data['username'] = 'rougin';

        $data['password'] = '12345';

        $result = $check->valid($data);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function test_failed_validation()
    {
        $check = new UserCheck;

        $data = array('name' => 'Rougin');

        $data['username'] = 'rougin';

        $check->valid($data);

        $expected = array('password' => array());
        $expected['password'][] = 'Password is required';

        $actual = $check->errors();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_failed_validation_with_data()
    {
        $check = new UserCheckWithData;

        $check->valid();

        $expected = array('username' => array());
        $expected['username'][] = 'Username is required';

        $actual = $check->errors();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_first_error_from_failed_validation()
    {
        $check = new UserCheckWithData;

        $check->valid();

        $expected = 'Username is required';

        $actual = $check->firstError();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_first_error_from_passed_validation()
    {
        $check = new UserCheck;

        $data = array('name' => 'Rougin');

        $data['username'] = 'rougin';

        $data['password'] = '12345';

        $check->valid($data);

        $actual = $check->firstError();

        $this->assertNull($actual);
    }
}
