<?php

namespace Rougin\Weasley\Fixture\Checks;

use Rougin\Weasley\Check;

/**
 * User Check
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class UserCheck extends Check
{
    /**
     * Sets the labels in the validator.
     *
     * @return array<string, string>
     */
    public function labels()
    {
        $labels = array('name' => 'Name');

        $labels['username'] = 'Username';

        $labels['password'] = 'Password';

        return $labels;
    }

    /**
     * Sets the rules in the validator.
     *
     * @param  array<string, mixed> $data
     * @return array<string, string>
     */
    public function rules(array $data)
    {
        $rules = array('name' => 'required');

        $rules['username'] = 'required';

        $rules['password'] = 'required';

        return (array) $rules;
    }
}
