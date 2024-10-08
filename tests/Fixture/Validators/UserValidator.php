<?php

namespace Rougin\Weasley\Fixture\Validators;

use Rougin\Weasley\Validators\AbstractValidator;

/**
 * User Validator
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class UserValidator extends AbstractValidator
{
    /**
     * Sets the labels in the validator.
     *
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
     * Sets the rules in the validator.
     *
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
