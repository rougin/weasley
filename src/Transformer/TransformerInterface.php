<?php

namespace Rougin\Weasley\Transformer;

use Rougin\Weasley\Contract\Mutator;

/**
 * @deprecated since ~0.7, use "Contract/Mutator" instead.
 *
 * Transformer Interface
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
interface TransformerInterface extends Mutator
{
    /**
     * @deprecated since ~0.7, use "mutate" instead.
     *
     * Transforms the contents of the result.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function transform($data);
}
