<?php

namespace Rougin\Weasley\Transformer;

/**
 * Transformer Interface
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface TransformerInterface
{
    /**
     * Transforms the contents of the result.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function transform($data);
}
