<?php

namespace App\Validators;

use Rougin\Weasley\Validators\AbstractValidator;

/**
 * TestValidator
 *
 * @package App
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class TestValidator extends AbstractValidator
{
    /**
     * Sets the labels in the validator.
     *
     * @return array<string, string>
     */
    protected function labels()
    {
        $labels = array();

        //

        return $labels;
    }

    /**
     * Sets the rules in the validator.
     *
     * @param  array<string, mixed> $data
     * @return void
     */
    protected function rules(array $data = array())
    {
        //
    }
}
