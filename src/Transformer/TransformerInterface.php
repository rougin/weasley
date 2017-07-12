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
     * @param  mixed   $data
     * @param  integer $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function transform($data, $code = 200);
}
