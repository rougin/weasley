<?php

namespace {{ application }}\{{ namespaces.validators }};

use Valitron\Validator;

/**
 * {{ singular | title }} Validator
 *
 * @package {{ application }}
 * @author  {{ author }} <{{ email }}>
 */
class {{ singular | title }}Validator extends BaseValidator
{
    /**
     * Sets the labels in the validator.
     * 
     * @param  \Valitron\Validator $validator
     * @return void
     */
    protected function setLabels(Validator &$validator)
    {
        //
    }

    /**
     * Sets the rules in the validator.
     * 
     * @param  \Valitron\Validator $validator
     * @param  array $data
     * @return void
     */
    protected function setRules(Validator &$validator, $data = [])
    {
        {{ columns | raw }}
    }
}
