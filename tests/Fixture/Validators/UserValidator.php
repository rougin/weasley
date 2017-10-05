<?php

namespace Rougin\Weasley\Fixture\Validators;

/**
 * User Validator
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class UserValidator extends \Rougin\Weasley\Validators\AbstractValidator
{
    /**
     * Sets the labels in the validator.
     *
     * @return array
     */
    protected function labels()
    {
        $labels = array();

        $labels['name'] = 'Name';
        $labels['username'] = 'Username';
        $labels['password'] = 'Password';

        return $labels;
    }

    /**
     * Sets the rules in the validator.
     *
     * @param  array $data
     * @return void
     */
    protected function rules(array $data = array())
    {
        $this->validator->rule('required', 'name');
        $this->validator->rule('required', 'username');
        $this->validator->rule('required', 'password');
    }
}
