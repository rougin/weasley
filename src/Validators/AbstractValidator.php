<?php

namespace Rougin\Weasley\Validators;

use Valitron\Validator;

/**
 * Abstract Validator
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractValidator
{
    /**
     * @var array
     */
    public $errors = array();

    /**
     * @var \Valitron\Validator
     */
    protected $validator;

    /**
     * Creates a new validator instance.
     */
    public function __construct()
    {
        $this->validator = new Validator;
    }

    /**
     * Sets the labels in the validator.
     *
     * @return array
     */
    abstract protected function labels();

    /**
     * Sets the rules in the validator.
     *
     * @param  array $data
     * @return void
     */
    abstract protected function rules(array $data = array());

    /**
     * Validates the given data against the specified rules.
     *
     * @param  array $data
     * @return boolean
     */
    public function validate(array $data)
    {
        $this->validator->labels($this->labels());

        $this->rules($data);

        $validator = $this->validator->withData($data);

        $validated = $validator->validate();

        $errors = $validator->errors();

        is_array($errors) && $this->errors = $errors;

        return $validated;
    }
}
