<?php

namespace Rougin\Weasley\Contract;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
interface Mutator
{
    /**
     * Mutates the contents of the result.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function mutate($data);
}
