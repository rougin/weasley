<?php

namespace Rougin\Weasley\Fixture\Validators;

use Rougin\Weasley\Validators\AbstractValidator;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SampleValidator extends AbstractValidator
{
    /**
     * @return array<string, string>
     */
    protected function labels()
    {
        $labels = array('name' => 'Type');

        $labels['year'] = 'Year';

        $labels['component'] = 'Component';

        $labels['status'] = 'Status';

        $labels['date_start'] = 'Date Start';

        $labels['date_end'] = 'Date End';

        return $labels;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return void
     */
    protected function rules(array $data = array())
    {
        $this->validator->rule('required', 'name');

        $this->validator->rule('required', 'year');

        $this->validator->rule('required', 'component');

        $this->validator->rule('required', 'status');

        $this->validator->rule('required', 'date_start');

        $this->validator->rule('required', 'date_end');
    }
}
