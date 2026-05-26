<?php

namespace Rougin\Weasley\Fixture\Validators;

use Rougin\Weasley\Validators\AbstractValidator;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class UserValidator extends AbstractValidator
{
    /**
     * @return array<string, string>
     */
    protected function labels()
    {
        $labels = array('name' => 'Name');

        $labels['username'] = 'Username';

        $labels['password'] = 'Password';

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

        $this->validator->rule('required', 'username');

        $this->validator->rule('required', 'password');
    }
}
