<?php

namespace Rougin\Weasley\Handlers;

/**
 * Trim String Middleware
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class TrimStringValue extends MutateRequest
{
    /**
     * Mutates the specified value.
     *
     * @param  mixed $value
     * @return mixed
     */
    protected function mutate($value)
    {
        return is_string($value) ? trim($value) : $value;
    }
}
