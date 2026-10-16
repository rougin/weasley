<?php

namespace Rougin\Weasley\Validators;

use Rougin\Weasley\Fixture\Validators\SampleValidator;
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
    public function test_passed_if_all_fields_valid()
    {
        $validator = new SampleValidator;

        $data = array('name' => 'Regular');

        $data['year'] = 2026;

        $data['component'] = 'Home';

        $data['status'] = 'active';

        $data['date_start'] = '2026-01-01';

        $data['date_end'] = '2026-12-31';

        $actual = $validator->validate($data);

        $this->assertTrue($actual);
    }

    /**
     * @return void
     */
    public function test_failed_if_field_missing()
    {
        $validator = new SampleValidator;

        $data = array('name' => 'Regular');

        $data['component'] = 'Home';

        $data['status'] = 'active';

        $data['date_start'] = '2026-01-01';

        $data['date_end'] = '2026-12-31';

        $actual = $validator->validate($data);

        $this->assertFalse($actual);

        $expect = array('year' => array('Year is required'));

        $this->assertEquals($expect, $validator->errors);
    }
}
