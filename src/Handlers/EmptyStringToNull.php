<?php

namespace Rougin\Weasley\Handlers;

/**
 * Empty String To Null Middleware
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class EmptyStringToNull extends MutateRequest
{
    /**
     * Mutates the specified value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function mutate($value)
    {
        return is_string($value) && $value === '' ? null : $value;
    }
}
