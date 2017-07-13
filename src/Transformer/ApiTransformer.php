<?php

namespace Rougin\Weasley\Transformer;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * API Transformer
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ApiTransformer implements TransformerInterface
{
    /**
     * Transforms the contents of the result.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function transform($data)
    {
        $paginator = 'Illuminate\Contracts\Pagination\LengthAwarePaginator';

        return is_a($data, $paginator) ? $this->paginator($data) : $data->toArray();
    }

    /**
     * Converts the paginator into Paypal API standards.
     *
     * @param  \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @return array
     */
    protected function paginator(LengthAwarePaginator $paginator)
    {
        list($response, $result) = array(array(), $paginator->toArray());

        $response['total_items'] = $result['total'];
        $response['total_pages'] = $result['total'] / $result['per_page'];
        $response['items'] = $result['data'];

        return $response;
    }
}
