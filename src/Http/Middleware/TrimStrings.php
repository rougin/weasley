<?php

namespace Rougin\Weasley\Http\Middleware;

/**
 * "Trim Strings" Middleware
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TrimStrings extends TransformRequest
{
    /**
     * Transforms the specified value.
     *
     * @param  mixed $value
     * @return mixed
     */
    protected function transform($value)
    {
        return is_string($value) ? trim($value) : $value;
    }
}
