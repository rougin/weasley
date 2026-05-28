<?php

namespace Rougin\Weasley\Handlers;

use Rougin\Onion\Transform;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MutateRequest extends Transform
{
    /**
     * Maps the array to mutate each value.
     *
     * @param array<string, mixed> $items
     *
     * @return array<string, mixed>
     */
    protected function map($items)
    {
        foreach ($items as $key => $value)
        {
            $mutated = $this->mutate($value);

            // Backward compatibility code from "mutate" ---
            if ($mutated === $value)
            {
                $mutated = $this->transform($mutated);
            }
            // ---------------------------------------------

            if (is_array($value))
            {
                $mutated = $this->map($value);
            }

            $items[$key] = $mutated;
        }

        return $items;
    }

    /**
     * @deprecated since ~0.7, use "mutate" instead.
     *
     * Transforms the specified value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function transform($value)
    {
        return $value;
    }

    /**
     * Mutates the specified value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function mutate($value)
    {
        return $value;
    }
}
