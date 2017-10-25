<?php

namespace Rougin\Weasley\Http\Middleware;

/**
 * "Empty Strings To Null" Middleware
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class EmptyStringsToNull extends TransformRequest
{
    /**
     * Transforms the specified value.
     *
     * @param  mixed $value
     * @return mixed
     */
    protected function transform($value)
    {
        return is_string($value) && $value === '' ? null : $value;
    }
}
