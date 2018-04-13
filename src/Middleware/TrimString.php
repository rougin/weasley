<?php

namespace Rougin\Weasley\Middleware;

/**
 * Trim String Middleware
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TrimString extends TransformRequest
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
