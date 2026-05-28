<?php

namespace Rougin\Weasley\Validators;

use Rougin\Valla\Valid;

/**
 * @deprecated since ~0.8, use "Check" instead.
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
abstract class AbstractValidator
{
    /**
     * @deprecated since ~0.8, use "errors()" instead.
     *
     * @var array<string, string[]>
     */
    public $errors = array();

    /**
     * @var \Rougin\Valla\Valid
     */
    protected $valid;

    public function __construct()
    {
        $this->valid = new Valid;
    }

    /**
     * Sets the labels in the validator.
     *
     * @return array<string, string>
     */
    abstract protected function labels();

    /**
     * @deprecated since ~0.8, use "rules" property and "valid" method instead.
     *
     * Sets the rules in the validator.
     *
     * @param array<string, mixed> $data
     *
     * @return void
     */
    abstract protected function rules(array $data = array());

    /**
     * @deprecated since ~0.8, use "valid" instead.
     *
     * Validates the given data against the specified rules.
     *
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function validate(array $data)
    {
        $this->valid->setLabels($this->labels());

        $this->rules($data);

        $this->valid->setData($data);

        if ($this->valid->passed())
        {
            return true;
        }

        $this->errors = $this->valid->getErrors();

        return false;
    }
}
