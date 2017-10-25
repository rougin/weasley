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
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        return is_string($value) ? trim($value) : $value;
    }
}
