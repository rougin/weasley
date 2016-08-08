<?php

namespace {{ application.name }}\{{ namespaces.validators }};

use Valitron\Validator;

/**
 * {{ singular | title | replace({ '_': ' ' }) }} Validator
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class {{ singularTitle }}Validator extends BaseValidator
{
    /**
     * Sets the labels in the validator.
     * 
     * @param  \Valitron\Validator $validator
     * @return void
     */
    protected function setLabels(Validator &$validator)
    {
        $validator->labels([
            {{ labels | raw }}
        ]);
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
        {{ rules | raw }}
    }
}
