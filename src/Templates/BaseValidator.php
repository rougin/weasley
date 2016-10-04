<?php

namespace {{ application.name }}\{{ namespaces.validators }};

/**
 * Base Validator
 *
 * A base class for a validator.
 * 
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class BaseValidator
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var \Valitron\Validator
     */
    protected $validator;

    /**
     * Returns a listing of error, if any.
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Validates the data from the registration page.
     * 
     * @param  array  $data
     * @return boolean
     */
    public function validate(array $data)
    {
        $this->validator = new \Valitron\Validator($data);

        $this->setLabels();
        $this->setRules($data);

        if ( ! $this->validator->validate()) {
            $this->errors = $this->validator->errors();

            return false;
        }

        return true;
    }
}
