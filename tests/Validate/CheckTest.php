<?php

namespace Rougin\Weasley;

use Rougin\Weasley\Fixture\Checks\UserCheck;
use Rougin\Weasley\Fixture\Checks\UserCheckWithData;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CheckTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_data_missing_field()
    {
        $check = new UserCheckWithData;

        $data = array('name' => 'Rougin');

        $data['password'] = '1234';

        $check->valid($data);

        $expect = array('username' => array());

        $expect['username'][] = 'Username is required';

        $actual = $check->errors();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_failed_if_field_missing()
    {
        $check = new UserCheck;

        $data = array('name' => 'Rougin');

        $data['username'] = 'rougin';

        $check->valid($data);

        $expect = array('password' => array());

        $expect['password'][] = 'Password is required';

        $actual = $check->errors();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_all_fields_valid()
    {
        $check = new UserCheck;

        $data = array('name' => 'Rougin');

        $data['username'] = 'rougin';

        $data['password'] = '12345';

        $actual = $check->valid($data);

        $this->assertTrue($actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_first_error_exists()
    {
        $check = new UserCheckWithData;

        $data = array('name' => 'Rougin');

        $data['password'] = '1234';

        $check->valid($data);

        $expect = 'Username is required';

        $actual = $check->firstError();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_first_error_null()
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
