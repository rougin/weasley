<?php

namespace Rougin\Weasley;

use Valitron\Validator;

/**
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
abstract class Check
{
    /**
     * @var array<string, string[]>
     */
    public $errors = array();

    /**
     * @var \Valitron\Validator
     */
    protected $validator;

    public function __construct()
    {
        $this->validator = new Validator;
    }

    /**
     * Sets the labels in the validator.
     *
     * @return array<string, string>
     */
    abstract protected function labels();

    /**
     * Sets the rules in the validator.
     *
     * @param  array<string, mixed> $data
     * @return void
     */
    abstract protected function rules(array $data = array());

    /**
     * Validates the given data against the specified rules.
     *
     * @param  array<string, mixed> $data
     * @return boolean
     */
    public function validate(array $data)
    {
        $this->validator->labels($this->labels());

        $this->rules($data);

        $validator = $this->validator->withData($data);

        if ($validator->validate())
        {
            return true;
        }

        /** @var array<string, string[]> */
        $errors = $validator->errors();

        $this->errors = $errors;

        return false;
    }
}
