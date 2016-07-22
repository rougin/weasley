<?php

namespace {{ application.name }}\{{ namespaces.validators }};

use Valitron\Validator;

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
        $validator = new Validator($data);

        $this->setLabels($validator);
        $this->setRules($validator, $data);

        if ( ! $validator->validate()) {
            $this->errors = $validator->errors();

            return false;
        }

        return true;
    }
}
