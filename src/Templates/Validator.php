<?php

namespace {{ application.name }}\{{ namespaces.validators }};

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
     * @return void
     */
    protected function setLabels()
    {
        $this->validator->labels([
            {{ labels | raw }}
        ]);
    }

    /**
     * Sets the rules in the validator.
     *
     * @param  array $data
     * @return void
     */
    protected function setRules($data = [])
    {
        {{ rules | raw }}
    }
}
