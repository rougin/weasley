<?php

namespace Rougin\Weasley\Transformer;

use Illuminate\Contracts\Support\Arrayable;

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
     * @param  \Illuminate\Contracts\Support\Arrayable $data
     * @return array
     */
    protected function paginator(Arrayable $data)
    {
        list($response, $result) = array(array(), $data->toArray());

        $pages = ($result['total'] != 0 && $result['per_page'] > $result['total']) ? 1 : round($total / $result['per_page']);

        $response['total_items'] = $result['total'];
        $response['total_pages'] = $pages;
        $response['items'] = $result['data'];

        return $response;
    }
}
