<?php

namespace Rougin\Weasley\Fixture;

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

        $labels['name']     = 'Name';
        $labels['password'] = 'Password';
        $labels['username'] = 'Username';

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
        $this->validator->rule('required', 'password');
        $this->validator->rule('required', 'username');
    }
}
